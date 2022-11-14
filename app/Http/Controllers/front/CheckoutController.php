<?php

namespace App\Http\Controllers\front;

use App\Events\OrderCompleted;
use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckoutController extends Controller
{

    public function show()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        } else {
            $carts  = Cart::with('product')->where('user_id', Auth::user()->id)->get();
            return view('checkout', [
                'carts' => $carts
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $user = $request->user(); //Auth::user();
        DB::beginTransaction();
        try {
            // $order = Order::create([
            //     'user_id' => Auth::id(),
            //     'status' => 'pending'
            // ]);
            $order = $user->order()->create([
                'status' => 'pending',
            ]);
            $total = 0;
            $carts  = Cart::where('user_id', Auth::user()->id)->get();
            foreach ($carts as $item) {
                $order->orderProducts()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
                $total += $item->quantity * $item->price;
                // OrderProduct::create([
                //     'order_id' => $order->id,
                //     'product_id' => $item->product_id,
                //     'quantity' => $item->quantity,
                //     'price' => $item->price,
                // ]);
            }
            // $user->cart()->delete();
            Cart::where('user_id', Auth::user()->id)->delete();
            DB::commit();

            //if i wana to make an evet eg.send emailNotification for user who create the order    
            event(new OrderCreated($order));

            //the real payment for this checkout
            return $this->paypal($order, $total);
            return redirect()->route('orders')->with('success', __('Order #:id Completed and Created ', ['id' => $order->id]));

        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    protected function paypal(Order $order, $total)
    {
        $client = $this->paypalClient();
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" => $total,
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('paypal.cancel')),
                "return_url" => url(route('paypal.callback')),
            ]
        ];

        try {
            $response = $client->execute($request);
            if ($response->statusCode == 201 && isset($response->result)) {
                Session::put('paypal_order_id', $response->result->id); //ال اي دي الفعلي تبع بيبال مش تبع اوردر اليورز
                Session::put('order_id', $order->id);
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href); // to redirect user for external site 
                    }
                }
            }
        } catch (HttpException  $ex) {
            echo $ex->statusCode;
            return $ex->getMessage();
        }
        //المفروض هنا ابعته ع فيو مصممة وابعته معها هاد الستيتس كود واعرض له الخطأ تبعه فيه
        return 'Unknown Error !' . $response->statusCode;
    }

    protected function paypalClient()
    {
        $config = Config('services.paypal');
        $client_id = $config['client_id'];
        $client_secret = $config['client_secret'];
        $mode = $config['mode'];
        if ($mode == 'sandbox') {
            $env = new SandboxEnvironment($client_id, $client_secret);
        } else {
            $env = new ProductionEnvironment($client_id, $client_secret);
        }
        $client = new PayPalHttpClient($env);
        return $client;
    }



    public function paypalCallback()
    {
        $paypal_order_id = Session::get('paypal_order_id');
        $client = $this->paypalClient();

        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->prefer('return=representation');
        try {
            $response = $client->execute($request);
            if ($response->statusCode == 201) {
                if (strtoupper($response->result->status) == 'COMPLETED') {
                    $id = Session::get('order_id'); // the real order id for my user
                    $order = Order::findOrFail($id);
                    $order->status = 'completed';
                    $order->save();
                    Session::forget(['order_id', 'paypal_order_id']);
                   
                    return redirect()->route('orders')->with('success', __('Order #:id Completed and Created ', ['id' => $order->id]));
                }
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            return $ex->getMessage();
        }
    }
}
