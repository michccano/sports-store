@extends('layouts.auth')

@section('title', 'Register')

@section('content')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create New Account</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{route("storeProduct")}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >First Name</label>
                                                <input type="text" class="form-control" name="firstname" placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Last Name</label>
                                                <input type="text" class="form-control" name="lastname" placeholder="Enter Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Enter Email Address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Address1</label>
                                                <input type="text" class="form-control" name="address1" placeholder="Enter Address1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Address2</label>
                                                <input type="text" class="form-control" name="address2" placeholder="Enter Address2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >City</label>
                                                <input type="text" class="form-control" name="city" placeholder="Enter City">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >State</label>
                                                <input type="text" class="form-control" name="state" placeholder="Enter State">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Postal Code</label>
                                                <input type="text" class="form-control" name="postal" placeholder="Enter Postal Code">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Country</label>
                                                <input type="text" class="form-control" name="country" placeholder="Enter Country">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Day Phone</label>
                                                <input type="text" class="form-control" name="dayphone" placeholder="Enter Day Phone">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Eve Phone</label>
                                                <input type="text" class="form-control" name="evephone" placeholder="Enter Eve Phone">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                    <a href="#">Already have and account? Login here</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
