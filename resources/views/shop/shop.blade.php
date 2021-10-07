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
                        <li>
                            <a href="#">
                                <span>UNCATEGORIZED </span>
                                <span class="category-count">(0)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>ACCESSORIES </span>
                                <span class="category-count">(0)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>CLOTHING </span>
                                <span class="category-count">(0)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>SHOES </span>
                                <span class="category-count">(0)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>T-SHIRTS </span>
                                <span class="category-count">(0)</span>
                            </a>
                        </li>
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
                                    <div class="col-lg-4 mb-4">
                                        <div class="shop-single-item">
                                            <span class="onsale ">Sale!</span>
                                            <div class="card">
                                                <img src="/assets/img/product-1.jpg" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <a href="#" class="product-cart-btn">
                                                        <del>$4.00</del>
                                                        <span>$3.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="add-to-cart-btn-wrap">
                                                <div class="hero-button-area">
                                                    <a href="#">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($products as $product)
                                    <div class="col-lg-4 mb-4">
                                        <div class="shop-single-item">
                                            <div class="card">
                                                <img src="{{asset('images/' . $product->img)}}" class="card-img-top">
                                                <div class="card-body">
                                                    <h5 class="card-title text-truncate">{{$product->name}}</h5>
                                                    <div class="info-area-btn">
                                                    <p class="product-cart-btn">
                                                        <span>${{$product->price}}</span>
                                                    </p>
                                                    <a href="{{route("productDetails",$product->id)}}" class="product-cart-btn">
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
                                                        <a  class="" onclick="addToCart({{$product->id}})">Add to cart</a>
                                                    </div>
                                                </div>

                                            @endif


                                        </div>
                                    </div>
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
                url: 'cart/store/'+id,
                type: 'GET',
                success: function (data) {
                    $('#inCart'+id).show();
                    $('#addCart'+id).hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart <span class="product-count"> ${+data}</span>`);
                },
                error: function () {
                    console.log('error');
                }
            });
        }
    </script>
@endsection
