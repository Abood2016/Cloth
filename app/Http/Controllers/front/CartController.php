<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Uuid;

class CartController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $carts = $this->getcarts();

        $cart_id = Cart::where('id', $this->getCartId())->first();
        if ($cart_id) {
            if ($cart_id->id === $this->getCartId() && Auth::check()) {
                DB::table('carts')
                    ->where('id', $this->getCartId())
                    ->update(['user_id' => $user_id]);
            }
        }

        $total = $this->getCartTotal();

        return view('cart', [
            'carts' => $carts,
            'total' => $total,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'int|min:1',
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $quantity = $request->post('quantity', 1);
        //way one to add to cart
        $cart = Cart::where([
            'id' => $this->getCartId(),
            'product_id' => $product->id,
        ])->first();

        if ($cart) {
            Cart::where([
                'id' => $this->getCartId(),
                'product_id' => $product->id
            ])->update([
                'quantity' => $cart->quantity + $quantity,
            ]);
        } else {
            Cart::create([
                'id' => $this->getCartId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
            ]);
        }


        if ($request->expectsJson()) {

            // return [
            //     'message' => 'Product added to cart',
            //     'cart' => $this->getCarts(),
            //     'total' => $this->getCartTotal(),
            // ];
            $data = [
                'cart' => $this->getCarts(),
                'total' => $this->getCartTotal(),
                'message' => 'Product added to cart'
            ];
            return Response::json(['data' => $data, 'status' => 200]);
        }
        return  redirect()->route('cart.index')
            ->with(
                'success',
                __('Product :name added to cart', ['name' => $product->name])
            );
    }


    public function update(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'array']
        ]);
        $that = $this;
        foreach ($request->post('quantity') as $product_id => $quantity) {
            $result =  Cart::where('product_id', $product_id)
                ->where(function ($query) use ($that) {
                    $query->where('id', '=', $that->getCartId())
                        ->orWhere('user_id', '=', Auth::id());
                })->update([
                    'quantity' => $quantity,
                ]);
        }
        if ($result) {
            return redirect()->back()->with('success','Cart Updated');
        } else {
            return redirect()->back()->with('error','Error');
        }
    }


    public function getCartId()
    {
        $request = request();
        $id = $request->cookie('cart_id');
        if (!$id) {
            $uuid = Uuid::uuid1(); // 28bc85wi82wcd5 like that
            $id = $uuid->toString();
            Cookie::queue(Cookie::make('cart_id', $id, 43800)); // 43800 month
        }
        return $id;
    }

    public function delete()
    {
        $cart = Cart::where(['id' => $this->getCartId(), 'user_id' => Auth::id()])->first();
        $cart->delete();
        return redirect()->back()->with([
            'success' => 'Item Deleted Successfully'
        ]);
    }

    protected function getCarts()
    {
        $user_id = Auth::id();
        $carts  = Cart::with('product')
            ->where('id', $this->getCartId())
            ->when($user_id, function ($query, $user_id) {
                $query->where('user_id', $user_id)->orWhereNull('user_id');
            })
            ->get();
        return $carts;
    }

    protected function getCartTotal()
    {
        $total = $this->getcarts()->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return $total;
    }
}
