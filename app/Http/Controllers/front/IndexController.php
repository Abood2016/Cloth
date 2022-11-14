<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->name . '%')->get();
       
        return view('front_partial._products')->with('products', $products);
    }
}
