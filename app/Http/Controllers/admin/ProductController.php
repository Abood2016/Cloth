<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\product_images;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;
use Throwable;

class ProductController extends Controller
{
    use UploadImageTrait;

    public function index(Request $request)
    {
        return view('admin.products.index', [
            'locale' => App::getLocale(),
        ]);
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $products = DB::table('products')
                ->Join('categories', 'categories.id', '=', 'products.category_id');

            $products->select([
                'products.*', 'categories.name as category_name',
                DB::raw("DATE_FORMAT(products.created_at, '%Y-%m-%d') as Date"),
            ])->get();

            return  DataTables::of($products)
                ->addColumn('actions', function ($products) {
                    $btn = "";
                    if (Gate::denies('products.edit')) {
                    } else {
                        $btn = '<a href="/dashboard/products/edit/' . $products->id . '" class=""  title="تعديل المنتج"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
                    }
                    if (Gate::denies('products.delete')) {
                    } else {
                        $btn = $btn . '<a href="/dashboard/products/delete/' . $products->id . '" data-id="' . $products->id . '" class="ConfirmLink "' . ' id="' . $products->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                    }
                    $btn = $btn . '<a href="/dashboard/products/show/' . $products->id . '" data-id="' . $products->id . '" title="عرض المنتج"><i class="fas fa-align-justify pl-2" style="color:#28B463"></i></a>';
                    return $btn;
                })->addColumn('image', function ($products) {
                    $url = asset('images/products/cover_image/' . $products->image);
                    return '<img src="' . $url . '" border="0" style="border-radius: 10px;" width="40" class="img-rounded" align="center" />';
                })->rawColumns(['actions', 'image'])->make(true);
        }
    }


    public function create()
    {
        if (!Gate::allows('products.create')) {
            abort(505);
        }
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('admin.products.create', compact('categories', 'tags'));
    }


    public function store(ProductRequest $request)
    {
        if (Gate::denies('products.create')) {
            abort(505);
        }

        $file_name =  $this->saveImages($request->image, 'images/products/cover_image');
        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'admin_id' => auth()->guard('admin')->id(),
                'price' => $request->price,
                'image' => $file_name,
            ]);
            if ($request->images && count($request->images) > 0) {
                $i = 1;
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
            throw $e;
            return response()->json(['status' => 2, "msg" => 'حدث خطأ في ادخال البيانات']);
        }
        return response()->json(['status' => 1, "msg" => "تم إضافة المنتج \"$product->name\" بنجاح"]);
    }


    public function edit($id)
    {
        //طريقتين للمنع
        // Gate::authorize('products.edit');

        if (!Gate::allows('products.edit')) {
            // return response()->json('Authorization Error',403);
            abort(505);
        }

        $product = Product::with(['media'])->where('id', $id)->first();
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('admin.products.edit', compact('categories', 'product', 'tags'));
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->with(['category', 'media'])->first();
        // $product_stores =  $product->user()->with('store')->get();
        if ($product == null) {
            abort(404, 'المنتج غير موجود');
        }
        return view('admin.products.show', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        if (!Gate::allows('products.edit')) {
            // return response()->json('Authorization Error',403);
            abort(505);
        }

        $product = Product::where('id', $id)->first();

        $data['name']  = $request->name;
        $data['price']    = $request->price;
        $data['description']    = $request->description;
        $data['category_id']    = $request->category_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
            if (File::exists(public_path('/images/products/cover_image/') . $product->image)) {
                File::delete(public_path('/images/products/cover_image/') . $product->image);
            }
            $file->move(public_path('/images/products/cover_image/'), $fileName);
            $data = ['image' => $fileName] + $data;
        }
        DB::beginTransaction();
        try {

            $product->update($data); //update product table

            if ($request->hasFile('images') && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename = $product->name . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('images/products/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                    //update product image table
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
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return response()->json(['status' => 2, "msg" => 'حدث خطأ في ادخال البيانات']);
        }

        return response()->json(['status' => 1, "msg" => "تم تعديل المنتج \"$product->name\" بنجاح"]);
    }

    public function removeImage($media_id)
    {
        $media = product_images::whereId($media_id)->first();
        if ($media) {
            if (File::exists('images/products/' . $media->image_name)) {
                unlink('images/products/' . $media->image_name);
            }
            $media->delete();
            return true;
        } else {
            return false;
        }
    }


    public function delete($id)
    {

        if (Gate::denies('products.delete')) {
            return response()->json(['status' => 2, "msg" => 'عذرآ لا تمتلك هذه الصلاحية']);
            abort(505);
        }

        $product = Product::whereId($id)->first();
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
                if ($productImages != null)
                    $productImages->delete();
                $product->delete();
                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
                return response()->json(['status' => 2, "msg" => 'حدث خطأ ما']);
            }

            return response()->json(['status' => 1, "msg" => "تم حذف المنتج \"$product->name\" بنجاح"]);
        }
    }


    public function getProducts()
    {
        $products = Product::orderBy('id','desc')->get();

        return view('admin.products.getProductsIndex',compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->name . '%')
        ->orWhere('price', 'like', '%' . $request->name . '%')
        ->get();
       if (!$products) {
           dd('null');
       }
        return view('admin.admin_partial._products')->with('products', $products);

    }
}
