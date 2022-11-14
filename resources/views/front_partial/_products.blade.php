
        <div class="ps-masonry" id="products" >
            <div class="grid-sizer"></div>
            @foreach ($products as $product)
                <div class="grid-item kids">
                    <div class="grid-item__content-wrapper">
                        <div class="ps-shoe mb-30">
                            <div class="ps-shoe__thumbnail">
                                @if ($product->status == 'new')
                                    <div class="ps-badge">
                                        <span>New</span>
                                    </div>
                                @endif
                                <a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img
                                    src="{{ asset('images/products/cover_image/' . $product->image) }}"
                                    alt=""><a class="ps-shoe__overlay" href="{{ route('product.show',$product->id) }}"></a>
                            </div>
                            <div class="ps-shoe__content">
                                <div class="ps-shoe__variants">
                                    <div class="ps-shoe__variant normal">
                                        @foreach ($product->media as $item)
                                            <img src="{{ asset('images/products/' . $item->image_name) }}"
                                                alt="">
                                        @endforeach
                                    </div>
                                </div>

                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">{{$product->name}}</a>
                                    <p class="ps-shoe__categories"><a href="#">{{$product->category->name}}</a></p>
                                    <span class="ps-shoe__price">
                                         £ {{$product->price}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- <div class="grid-item nike">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="{{ asset('front_assets/images/shoe/2.jpg') }}" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="{{ asset('front_assets/images/shoe/2.jpg') }}" alt=""><img
                                        src="{{ asset('front_assets/images/shoe/3.jpg') }}" alt=""><img src="{{ asset('front_assets/images/shoe/4.jpg') }}" alt=""><img
                                        src="{{ asset('front_assets/images/shoe/5.jpg') }}" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item adidas">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="images/shoe/3.jpg" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item kids">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                            <div class="ps-badge ps-badge--sale"><span>-35%</span></div><a
                                class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img
                                src="images/shoe/4.jpg" alt=""><a class="ps-shoe__overlay"
                                href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price">
                                    <del>£220</del> £ 120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item men">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="images/shoe/5.jpg" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item women">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="images/shoe/6.jpg" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item kids">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="images/shoe/7.jpg" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-item kids">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i
                                    class="ps-icon-heart"></i></a><img src="images/shoe/8.jpg" alt=""><a
                                class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img
                                        src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img
                                        src="images/shoe/5.jpg" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">Air Jordan 7
                                    Retro</a>
                                <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#">
                                        Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £
                                    120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
  