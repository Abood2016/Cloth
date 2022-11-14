<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(5);

        return response()->json([
            'code' => 200,
            'data' => $tags,
            'message' => 'Data fetch Successfully',
        ]);
    }
}
