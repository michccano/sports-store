@extends('layouts.mainApp')

@section('title', 'Profile')

@section('content')
    <section class="profile-top-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
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
                        <div class="col-md-5">
                            <b>{{$member->firstname}} {{$member->lastname}}</b>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="/theme/dist/img/purchase.jpg" alt="" style="height: 90px; width: 100px">
                                    <p>{{ $member->purchaseToken ? $member->purchaseToken->total : 0 }}</p>
                                </div>
                                <div class="col-md-4">
                                    <img src="/theme/dist/img/bonustoken.png" alt="" style="height: 90px; width: 100px">
                                    <p>{{$member->bonusToken ? $member->bonusToken->total : 0}}</p>
                                </div>
                                <div class="col-md-4">
                                    <img src="/theme/dist/img/makeup.jpg" alt="" style="height: 90px; width: 100px">
                                    <p>{{$member->makeupToken ? $member->makeupToken->total : 0}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <b>Product List</b>
                            <br>
                            <br>
                            @if(count($member->products)>0)
                                @foreach($member->products as $product)
                                    <a href="{{route('productDocument',$product->id)}}"><p>{{$product->name}}</p></a>
                                @endforeach
                            @else
                                <p>You don't have any product go to shop to purchase any product.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
