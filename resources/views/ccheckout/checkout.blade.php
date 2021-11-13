@extends('layouts.mainApp')

@section('title', 'Payment')

@section('content')
<section class="shop-category-main-area">
    <div class="container">
        <div class="shop-category-inner-wrap">
            <div class="shop-category-title">
                <h3>Pay From Card</h3>
            </div>
        </div>
    </div>
</section>
<section class="shop-product-main-area">
    <div class="container">
        <div class="shop-product-inner-wrap">
            <div class="shop-product-title checkout-page">

                <form action="{{ route('charge') }}" method="post">

                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-details-area">
                                <h3 class="mb-4">Product Details</h3>
                                <div class="product-details-content-image">
                                    <img src="" alt="Product Image">
                                </div>
                                <div class="product-details-content">
                                    <div class="p_name"><b>Name</b></div>
                                    <div class="p_details"><b>Price</b></div>
                                    @foreach($products as $product)
                                    <div class="p_name">{{$product->name}}</div>
                                    <div class="p_details">{{$product->price * $product->qty}}</div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input type="text" class="form-control" name="firstname" placeholder="Enter First Name" value="{{$user->firstname}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name" value="{{$user->lastname}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{{$user->address1}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>
                                        <input type="text" class="form-control" name="city" placeholder="Enter City" value="{{$user->city}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Post Code</label>
                                        <input type="text" class="form-control" name="postal" placeholder="Enter Post Code" value="{{$user->postal}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">State</label>
                                        <input type="text" class="form-control" name="state" placeholder="Enter State" value="{{$user->state}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Country</label>
                                        <input type="text" class="form-control" name="country" placeholder="Enter Country" value="{{$user->country}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" value="{{$user->dayphone}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Card Number</label>
                                        <input type="text" class="form-control" name="cc_number" placeholder="Enter Card Number" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Expire Month</label>
                                    <input type="text" class="form-control" name="expiry_month" placeholder="Enter Month" />
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Expire Year</label>
                                    <input type="text" class="form-control" name="expiry_year" placeholder="Enter Year" />
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Card CVV</label>
                                    <input type="text" class="form-control" name="cvv" placeholder="CVV" />
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary form-checkout-submit-btn">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
