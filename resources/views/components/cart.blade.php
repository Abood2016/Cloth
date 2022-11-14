<div class="ps-cart"><a class="ps-cart__toggle" href="#"><span><i
                id="cart-count">{{ $carts->count() }}</i></span><i class="ps-icon-shopping-cart"></i></a>
    <div class="ps-cart__listing">
        <div class="ps-cart__content" id="cart-list">
            @foreach ($carts as $cart)
                <div class="ps-cart-item">
                    {{-- <a class="ps-cart-item__close" href="#"></a> --}}
                    <div class="ps-cart-item__thumbnail"><a href="{{ route('product.show', $cart->product_id) }}"></a><img
                            src="{{ $cart->product->image_url }}" alt=""></div>
                    <div class="ps-cart-item__content"><a class="ps-cart-item__title"
                            href="{{ route('product.show', $cart->product_id) }}">
                            {{ $cart->product->name }}</a>
                        <p><span>Quantity:<i>{{ $cart->quantity }}</i></span><span>Total:<i>{{ $cart->quantity * $cart->product->price }}</i></span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="ps-cart__total" id="cart-item-count">
            <p>Number of items:<span>{{ $carts->count() }}</span></p>
            <p>Item Total:<span>{{ $total }}</span></p>
        </div>
        @if (auth()->check())
            <div class="ps-cart__footer"><a class="ps-btn" href="{{ route('show.checkout') }}">Check out<i
                        class="ps-icon-arrow-left"></i></a></div>
        @else
            <div class="ps-cart__footer"><a class="ps-btn" href="{{ route('login') }}">login For checkout<i
                        class="ps-icon-arrow-left"></i></a></div>
        @endif

    </div>
</div>
