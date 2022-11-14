<?php

namespace App\View\Components;

use App\Http\Controllers\front\CartController;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cookie;
use Ramsey\Uuid\Uuid;


class Cart extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $carts;
    public $total;
    public function __construct()
    {
        $user_id = Auth::id();
        $CartController = new CartController();
        $this->carts  = CartModel::with('product')
            ->where('id', $CartController->getCartId())
            ->when($user_id, function ($query, $user_id) {
                $query->where('user_id', $user_id)->orWhereNull('user_id');
            })->get();
        $this->total = $this->carts->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart');
    }
}
