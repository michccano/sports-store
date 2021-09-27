@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <br>
    <br>
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Login</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route("storeUser")}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label >Email</label>
                                    <input type="text" class="form-control" name="email"
                                           placeholder="Enter Email Address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label >Password</label>
                                    <input type="text" class="form-control" name="password"
                                           placeholder="Enter Password" value="{{ old('password') }}">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input type="checkbox" class="" name="remember" value="{{ old('password') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label >Remember Me</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Login</button>
                                <a href="#">Don't have any account? Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
