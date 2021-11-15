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
                    </div>
                </div>
            </div>
    </section>
    @if(session('successMessage'))
        <p class="alert alert-success">{{session('successMessage')}}</p>
    @elseif(session('errorMessage'))
        <p class="alert alert-danger">{{session('errorMessage')}}</p>
    @endif
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
                                                <p>{{$member->email}}</p>
                                                <p>{{$member->address1}}</p>
                                                <p>{{$member->address2}}</p>
                                                <p>{{$member->city}}</p>
                                                <p>{{$member->state}}</p>
                                                <p>{{$member->postal}}</p>
                                                <p>{{$member->country}}</p>
                                                <p>{{$member->dayphone}}</p>
                                                <p>{{$member->evephone}}</p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-4">
                                            <div class="">
                                                <a class="btn btn-primary" href="{{route("editInfo")}}" >Edit</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
