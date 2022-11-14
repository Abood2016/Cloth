<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ public_path('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ public_path('bootstrap/css/bootstrap.min.css') }}">



    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            border: 60px;
        }

    </style>
    <style>
        .table {
            width: 100%;
            margin-bottom: 20px;
        }

        .h2 {
            color: blue;
        }

        .tabletest2 {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
            margin-top: 20px;
            margin-bottom: 40px;
            border-collapse: collapse;
            width: 100%;

        }

        table {
            border-collapse: separate;
            text-indent: initial;
            border-spacing: 2px;
        }

        .tbod {
            border-bottom: 1px solid #ddd;
            text-align: center !important;
        }

    </style>
</head>

<body>
    <div class="row text-center" style="text-align: center">
        <div class="col-md-9">
            <span>Order Invoice</span>
        </div>

        <img src="{{ public_path('logo.png') }}" style="width: 100px;height: 100px;">
    </div>
    <br>
    <div class="row">
        <div class="col-md-9">
            <span></span>
        </div>
    </div>
    <table>
        {{-- @foreach ($order as $item) --}}
        <tr>
            <td style="font-weight: bold">Order Number :</td>
            <td>#{{ $order->id }}</td>
            <td style="font-weight: bold;text-align: right !important">Order Date :</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>
        </tr>
        {{-- @endforeach --}}
        <tr>
            <td style="font-weight: bold">Customer Name :</td>
            <td>{{ $order->user->name }}</td>
        </tr>
    </table>
    <hr>

    <h1>Customer Information</h1>
    {{-- <table>
        <tr>
            <td style="font-weight: bold">Customer Country :</td>
            <td>{{$order->adress->countries->name}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;text-align: right !important">Customer City :</td>
            <td>{{$order->adress->cities->name}}</td>
        </tr>

        <tr>
            <td style="font-weight: bold;text-align: right !important">Customer Phone :</td>
            <td>{{$order->phone}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;text-align: right !important">Customer Street Name :</td>
            <td>{{$order->street_name}}</td>
        </tr>
    </table> --}}

    <br>
    <hr>
    <h1>Order Items</h1>

    {{-- @foreach ($order->orderProducts as $item)


       <h4>Product Name : </h4> <p>{{ $item->product->getName() }}</p>
       <h4>Order Quantity : </h4> <p>{{ $item->quantity }}</p>
       <h4>Order Price : </h4>  <p>{{ $item->price }}</p>
       <h4>Product Total : </h4>   <p>{{ $item->price * $item->quantity  }}</p>
    @endforeach --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="text-align: center">#</th>
                <th scope="col" style="text-align: center">Product</th>
                <th scope="col" style="text-align: center">Quantity</th>
                <th scope="col" style="text-align: center">Price</th>
                <th scope="col" style="text-align: center">Product Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderProducts as $item)
                <tr>
                    <td style="text-align: center">{{ $item->order_id }}</td>
                    <td style="text-align: center">{{ $item->product->getName }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: center">{{ $item->price }}</td>
                    <td style="text-align: center">{{ $item->price * $item->quantity }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <hr>

    <script src="{{ public_path('bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ public_path('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
