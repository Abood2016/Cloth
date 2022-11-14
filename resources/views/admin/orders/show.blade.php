@extends("layouts.superAdmin")
@section('page_title')
    Order {{ $order->id }}
@endsection
@section('breadcrumb')

    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
        <li class="breadcrumb-item">
            <a href="/" class="text-muted">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="text-muted"> Order </a>
        </li>
    </ul>
@endsection

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header">

                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-supermarket text-primary"></i>
                        </span>
                    </div>
                    <div class="card-toolbar">

                        <a href="{{ route('orders') }}" class="btn btn-primary font-weight-bolder" title="رجوع">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                            </span>رجوع </a>
                    </div>
                  
                </div>
              
                <div class="card-body">
                    <div class="card-toolbar pb-2">
                        <a href="{{ route('orders.pdf',$order->id) }}" class="btn btn-primary font-weight-bolder" title="pdf">
                           PDF </a>
                    </div>
                    <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="1%">Order ID #</th>
                                                <th width="3%">User</th>
                                                <th width="3%">Status</th>
                                                <th width="3%">Product</th>
                                                <th width="3%">Quantity</th>
                                                <th width="3%">Price</th>
                                                <th width="3%">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($order->count() > 0)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td><span class="badge badge-success">{{ $order->status }}</span></td>
                                                    @foreach ($order->orderProducts as $item)
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->price }}</td>
                                                    @endforeach
                                                    <td>{{ $order->created_at->format('l d-m-y') }}</td>
                                                </tr>
                                            @endif
                                        <tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end: Datatable-->
                </div>
            </div>


        </div>
    </div>


@endsection
@section('css')
    <style>
        td {
            text-align: center;
        }

    </style>
@endsection()
