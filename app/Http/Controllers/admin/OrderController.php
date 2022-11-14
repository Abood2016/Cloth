<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use PDF;

class OrderController extends Controller
{
    public function printPdf(Order $order)
    {
        // $data = [
        //     'order' => $order
        // ];
     
        // dd($data->user_id);
        $pdf = PDF::loadView('admin.orders.invoice',compact('order'));
        $pdf->debug = true;
        return $pdf->download('invoice.pdf');
    }

}
