<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontProductController extends Controller
{

    public function show(Product $product)
    {
        return view('products.show',[
            'product' => $product
        ]);
    }

    
}
