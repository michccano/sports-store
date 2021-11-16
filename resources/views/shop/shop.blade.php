@extends('layouts.mainApp')

@section('title', 'Shop')

@section('content')
    <section class="shop-category-main-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
                <div class="shop-category-title">
                    <h3>Shop</h3>
                </div>
                <div class="shop-category-list">
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                <a href="#">
                                    <span class="text-capitalize">{{ $category->name }}</span>
                                    <span class="category-count">(0)</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="shop-product-main-area">
        <div class="container">
            <div class="shop-product-inner-wrap">
                <div class="shop-product-title">
                    @if(session('successMessage'))
                        <p class="alert alert-success">{{session('successMessage')}}</p>
                    @elseif(session('errorMessage'))
                        <p class="alert alert-danger">{{session('errorMessage')}}</p>
                    @endif
                    <p id="message" class=""></p>
                    <h3>Shop</h3>
                </div>
                <div class="shop-product-item-wrap">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="shop-product-items">
                                <div class="row">
                                    @foreach($products as $product)
                                        @if($product->price !=null || $product->price != 0)
                                            <div class="col-lg-4 mb-4">
                                                <div class="shop-single-item">
                                                    <div class="card">
                                                        <img src="{{asset('images/' . $product->img)}}"
                                                             class="card-img-top">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-truncate">{{$product->name}}</h5>
                                                            <div class="info-area-btn">
                                                                <p class="product-cart-btn">
                                                                    @if(!($product->season_price_expire_date <= \Illuminate\Support\Carbon::now()) || $product->season_price_expire_date == null)
                                                                        <span class="season-price" style="font-size: small">season: ${{$product->price}}</span>
                                                                    @endif

                                                                    @if(!($product->weekly_price_expire_date <= \Illuminate\Support\Carbon::now()) || $product->weekly_price_expire_date == null)
                                                                        @if($product->weekly_price != null && $product->weekly_price != 0)
                                                                            <span class="single-price" style="font-size: small">single: ${{$product->weekly_price}}</span>
                                                                        @endif
                                                                    @endif
                                                                </p>
                                                                <a href="{{route("productDetails",$product->id)}}"
                                                                   class="product-cart-btn">
                                                                    <span><i class="far fa-info"></i> Info</span>
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div id="" class="add-to-cart-btn-wrap">
                                                        <div class="hero-button-area">
                                                            <a href="{{route("productDetails",$product->id)}}">View
                                                                Details</a>
                                                        </div>
                                                    </div>
                                                    @if($cart->where('id',$product->id)->count())
                                                        <div id="" class="add-to-cart-season-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div id="inCart2{{$product->id}}" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                        <div id="addCart2{{$product->id}}" class="add-to-cart-season-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a onclick="addToCartSeasonal({{$product->id}})">Add to cart Season</a>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($cart->where('id',$product->id)->count())
                                                        <div id="" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div id="inCart{{$product->id}}" class="add-to-cart-single-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                        <div id="addCart{{$product->id}}" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="" onclick="addToCart({{$product->id}})">Add to cart single</a>
                                                            </div>
                                                        </div>

                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-4 mb-4">
                                                <div class="shop-single-item">
                                                    <div class="card">
                                                        <img src="{{asset('images/' . $product->img)}}"
                                                             class="card-img-top">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-truncate">{{$product->name}}</h5>
                                                            <div class="info-area-btn">
                                                                <p class="product-cart-btn">
                                                                    <span>${{$product->weekly_price}}</span>
                                                                </p>
                                                                <a href="{{route("productDetails",$product->id)}}"
                                                                   class="product-cart-btn">
                                                                    <span><i class="far fa-info"></i> Info</span>
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @if($cart->where('id',$product->id)->count())
                                                        <div id="" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div id="inCart{{$product->id}}" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="">In Cart</a>
                                                            </div>
                                                        </div>
                                                        <div id="addCart{{$product->id}}" class="add-to-cart-btn-wrap">
                                                            <div class="hero-button-area">
                                                                <a class="" onclick="addToCart({{$product->id}})">Add to
                                                                    cart</a>
                                                            </div>
                                                        </div>

                                                    @endif


                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <aside class="product-sidebar">
                                <div class="product-sidebar-title">
                                    <h3>Products</h3>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                            <aside class="product-sidebar mt-5">
                                <div class="product-sidebar-title">
                                    <h3>Top Rated Products</h3>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-sidebar-single-items">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <div class="sidebar-image-wrap">
                                                    <a href="#">
                                                        <img src="assets/img/sidebar-1.jpg"
                                                             class="img-fluid sidebar-image" alt="sidebar">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body product-sidebar-single">
                                                    <h5 class="card-title">
                                                        <a href="#">Backpack Pro</a>
                                                        <div class="product-rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <a href="#" class="product-cart-btn">
                                                            <del>$4.00</del>
                                                            <span>$3.00</span>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
    <script>
        function addToCart(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'cart/store/' + id,
                type: 'GET',
                success: function (data) {
                    $('#inCart' + id).show();
                    $('#addCart' + id).hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class", "alert alert-success");
                    $('#cartItemsNumber').html(`Cart <span class="product-count"> ${+data}</span>`);
                },
                error: function () {
                    console.log('error');
                }
            });
        }

        function addToCartSeasonal(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.storeSeasonal', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#inCart2' + id).show();
                    $('#addCart2' + id).hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data}</span>`);;
                },
                error: function () {
                }
            });
        }
    </script>
@endsection
