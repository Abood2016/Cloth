<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreateEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $order_id;
    protected $product;
    protected $email;
    protected $adminName;


    public function __construct($name, $order_id, $email , $adminName , $product)
    {
        $this->name = $name;
        $this->order_id = $order_id;
        $this->product = $product;
        $this->email = $email;
        $this->adminName = $adminName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('New Order Created');
        $this->from('no-reply@example.com', config('app.name'));
        $this->to($this->email);
        return $this->view('mails.order-created', [
            'name' => $this->name,
            'order_id' => $this->order_id,
            'adminName' => $this->adminName,
            'product' => $this->product,
        ]);
    }
}
