<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreateEmail;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderCreateEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $name = $order->user->name;
        $order_id = $order->id;
       
        foreach($order->orderProducts as $OrderProduct)
        {
            $product = $OrderProduct->product->name;
        }
       
        $email = Admin::where('type', 'super-admin')->first(); //or $email = Admin::where('type', 'super-admin')->first()->email;
        $email = $email->email;
        $adminName = Admin::where('type', 'super-admin')->first();
        $adminName = $adminName->name;

        Mail::send(new OrderCreateEmail($name, $order_id, $email, $adminName , $product));
    }
}
