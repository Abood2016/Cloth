<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
// use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function orders()
    {
        $order = Order::with('products')->where('user_id', Auth::id())->get();
        return response()->json(['status', 200, 'data', $order]);
    }

    public function index()
    {
        return view('admin.orders.index');
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $orders = DB::table('orders')
                ->Join('order_products', 'order_products.order_id', '=', 'orders.id')
                ->Join('products', 'order_products.product_id', '=', 'products.id')
                ->Join('users', 'orders.user_id', '=', 'users.id');
            $orders->select([
                'orders.*', 'orders.id as order_id', 'order_products.quantity as quantity',
                'order_products.price as price', 'products.name as product_name',
                'users.name as username',
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as Date"),
            ])->get();

            return  DataTables::of($orders)
                ->editColumn('status', function ($orders) {
                    return ($orders->status == 'completed') ? "<span class='badge badge-success'>$orders->status</span>" : "<span class='badge badge-primary'>$orders->status</span>";
                })->addColumn('actions', function ($orders) {
                    return '<a href="/dashboard/orders/delete/' . $orders->id . '" data-id="' . $orders->id . '" class="ConfirmLink "' . ' id="' . $orders->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>
                    <a href="/dashboard/orders/printpdf/' . $orders->id . '" data-id="' . $orders->id . '" title="pdf"><i class="fa fa-print"></i></a>;
                    <a href="/dashboard/orders/show/' . $orders->id . '" data-id="' . $orders->id . '" title="عرض الاوردر"><i class="fas fa-align-justify pl-2" style="color:#28B463"></i></a>';
                })->rawColumns(['actions', 'status'])->make(true);
        }
    }

    

    public function show(Order $order)
    {
        // dd($order->user->name);
        return view('admin.orders.show', ['order' => $order]);
    }

    public function delete($id)
    {
        $order = Order::where('id', $id)->first();
        if ($order) {
            $order->delete();
            return response()->json(['status' => 1, "msg" => "تم حذف الطلب  بنجاح"]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }
}
