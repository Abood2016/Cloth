<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $order = Order::paginate(5);
        $order = $order->load('user');
        return response()->json([
            'code' => 200,
            'data' => $order,
        ]);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'code' => 404,
                'message' => "Order Not Found !"
            ]);
        }

        $order = $order->load('user');
        return response()->json([
            'code' => 200,
            'data' => $order
        ]);
    }
}
