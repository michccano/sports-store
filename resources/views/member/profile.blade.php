@extends('layouts.mainApp')

@section('title', 'Profile')

@section('content')
    <section class="profile-top-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
                <div class="row">
                    <div class="row">
                        <div class="col">
                            <div class="shop-category-title">
                                <h3>Profile</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('logout') }}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="cart-product-body">
        <div class="container-md container-fluid">
            <div class="cart-product-inner-wrap">
                <div class="cart-product-top">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="user-profile-data">
                                                <img src="" alt="Profile">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="profile-info">
                                                <h4><b>{{$member->firstname}} {{$member->lastname}}</b></h4>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="profile-token">
                                                <img src="/theme/dist/img/purchase.jpg" alt="">
                                                <p>{{ $member->purchaseToken ? $member->purchaseToken->total : 0 }}</p>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="profile-token">
                                                <img src="/theme/dist/img/bonustoken.png" alt="">
                                                <p>{{$member->bonusToken ? $member->bonusToken->total : 0}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="profile-token">
                                                <img src="/theme/dist/img/makeup.jpg" alt="">
                                                <p>{{$member->makeupToken ? $member->makeupToken->total : 0}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <br>
                            <br>

                        </div>
                        <div class="col-md-5">
                            <b>Product List</b>
                            <br>
                            <br>
                            @if(count($member->products)>0)
                                @foreach($member->products as $product)
                                    <a href="{{route('productDocument',$product->id)}}">
                                        <p>{{$product->name}}</p>
                                    </a>
                                @endforeach
                            @else
                                <p>You don't have any product go to shop to purchase any product.</p>
                            @endif
                        </div>
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-nav-list-wrap">
            <div class="container-fluid">
                <div class="product-nav-list">
                    <nav class="navbar container">
                        <ul class="nav navbar-nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fas fa-home-lg-alt"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fal fa-user"></i> Profile Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="far fa-bags-shopping"></i> Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fal fa-sign-out"></i>
                                    <form action="{{ route('logout') }}" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-danger ">Logout</button>
                                    </form>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        {{--<div class="page-item-content">
            <div class="container">
                <div class="row">
                  <div class="col-md-4">
                    <div class="pricing-table">
                      <p>Free</p>
                      <div class="signup-btn">
                          <a href="#">Sing Up Now</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                  <div class="pricing-table">
                      <p>Free</p>
                      <div class="signup-btn">
                          <a href="#">Sing Up Now</a>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>--}}
    </section>
@endsection
