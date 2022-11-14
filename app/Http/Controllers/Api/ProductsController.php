<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\product_images;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Throwable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    use UploadImageTrait;

    public function __construct()
    {
        //  $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $category_id = $request->input('category_id');
        $keyWord = $request->input('search_keyword');

        $products = Product::when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })
            ->when($keyWord, function ($query, $keyWord) {
                return $query->where('name', 'LIKE', "%$keyWord%")
                    ->orWhere('description', 'LIKE', "%$keyWord%");
            })
            ->with('category')->paginate(10); //or use join

        return Response::json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        $data = new Product();

        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products/cover_image'), $fileName);
            $data['image'] = $fileName;
        }

        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'admin_id' => 1,
                'price' => $request->input('price'),
                'image' => $fileName,
            ]);
            //code to add multiple images
            if ($request->hasFile('images')) {
                $i = 1;
                // dd($request->images);
                foreach ($request->images as $file) {
                    $filename = $product->name . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('images/products/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                    product_images::create([
                        'image_name' => $filename,
                        'image_size' => $file_size,
                        'image_type' => $file_type,
                        'product_id' => $product->id,
                    ]);
                    $i++;
                }
            }
            $product->tags()->sync($request->tags);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'code' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
        return Response::json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product Not Found !'
            ], 404);
        }

        $product = $product->load('category', 'media', 'tags');

        return response()->json([
            'code' => 200,
            'data' => $product,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product Not Found !'
            ], 404);
        }

        if ($product) {
            if ($product->media->count() > 0) {
                foreach ($product->media as $media) {
                    if (File::exists('images/products/' . $media->image_name)) {
                        unlink('images/products/' . $media->image_name);
                    }
                    if (File::exists(public_path('/images/products/cover_image/') . $product->image)) {
                        File::delete(public_path('/images/products/cover_image/') . $product->image);
                    }
                }
            }
            DB::beginTransaction();
            try {
                $productImages = Product_images::where('product_id', "=", $product->id);
                $productOrders = OrderProduct::where('product_id', "=", $product->id);

                if ($productOrders != null)
                    $productOrders->delete();

                if ($productImages != null)
                    $productImages->delete();
                $product->delete();

                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
                return response()->json([
                    'code' => 401,
                    'message' => "Erorr" . $th->getMessage(),
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => "Product Deleted Successfully",
                'data' => $product,
            ]);
        }
    }
}
