<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoriesController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


    public function index()
    {
        $request = request();
        $keyword = $request->input('search_keyword');

        $categories = Category::when($keyword, function ($query, $keyword) {
            return $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%");
        })->paginate(10);

        return response()->json([
            'code' => 200,
            'data' => $categories,
        ]);
    }


    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {

            return response()->json([
                'code' => 404,
                'message' => "Category Not Found !"
            ]);
        }

        return response()->json([
            'code' => 200,
            'data' => $category,
            'message' => "Data Fetch Succssfully"
        ]);
    }
}
