@extends('layouts.front')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="ps-content pt-80 pb-80">
        <div class="ps-container">
            <div class="ps-cart-listing">
                <table class="table ps-cart__table">
                    <thead>
                        <tr>
                            <th>All Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //$total = 0;
                        ?>
                        @if ($carts->count() > 0)
                            @foreach ($carts as $item)
                                <tr id="row">
                                    <td><a class="ps-product__preview"
                                            href="{{ route('product.show', $item->product_id) }}"><img
                                                class="mr-15" height="80px"
                                                src="{{ asset('images/products/cover_image/' . $item->product->image) }}"
                                                alt=""> {{ $item->product->name }}</a></td>
                                    <td>{{ $item->price }}</td>
                                    <td>
                                        <div class="form-group--number">
                                            {{-- <button class="minus"><span>-</span></button> --}}
                                            <form action="{{ route('cart.update') }}" method="POST" id="quantity-form">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <input class="form-control" name="quantity[{{ $item->product_id }}]"
                                                    type="number" value="{{ $item->quantity }}" id="quantity">
                                                {{-- <div class="form-group text-right" > --}}
                                                    {{-- </div> --}}
                                                    <button  class="ps-btn ps-btn--gray" style="width: 50%;
                                                    text-align: center;
                                                    padding-top: 10px;">Update</button>
                                                </form>
                                            {{-- <button class="plus"><span>+</span></button> --}}
                                        </div>
                                    </td>
                                    <td>{{ $item->price * $item->quantity }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.delete', $item->id) }}">
                                            @csrf
                                            {{ method_field('PUT') }}
                                            @if (auth()->check())
                                                <button type="submit" class="ps-remove"></button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                <?php// $total += $item->price * $item->quantity; ?> 
                            @endforeach
                        @else
                            <tr class="text-center" id="no-data-record">
                                <td colspan="5">
                                    <img
                                        src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/v2/assets/empty.svg">
                                    <p class="mt-2">No Data In Your Cart </p>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                {{-- <div class="form-group text-right" id="update-btn">
                    <button class="ps-btn ps-btn--gray">Update Quantity</button>
                </div> --}}
                <div class="ps-cart__actions">
                    <div class="ps-cart__promotion">
                        <div class="form-group">
                            <div class="ps-form--icon"><i class="fa fa-angle-right"></i>
                                <input class="form-control" type="text" placeholder="Promo Code">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="ps-btn ps-btn--gray">Continue Shopping</button>
                        </div>
                    </div>
                    <div class="ps-cart__total">
                        <h3>Total Price: <span> {{ $total }}</span></h3>
                        @if (auth()->check())
                            <a class="ps-btn" href="{{ route('show.checkout') }}">
                                Process to checkout<i class="ps-icon-next"></i></a>
                        @else
                            <a class="ps-btn" href="{{ route('login') }}">
                                Login Checkout<i class="ps-icon-next"></i></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-subscribe">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 ">
                    <h3><i class="fa fa-envelope"></i>Sign up to Newsletter</h3>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12 col-xs-12 ">
                    <form class="ps-subscribe__form" action="do_action" method="post">
                        <input class="form-control" type="text" placeholder="">
                        <button>Sign up now</button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 ">
                    <p>...and receive <span>$20</span> coupon for first shopping.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
