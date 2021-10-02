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
                        @if(count($errors) > 0 )
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul class="p-0 m-0" style="list-style: none;">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- form start -->
                        <form action="{{route("loginPost")}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label >Email</label>
                                    <input type="text" class="form-control" name="email"
                                           placeholder="Enter Email Address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label >Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Enter Password" value="{{ old('password') }}">
                                </div>
                                <div class="form-group">
                                <a href="{{route('password.request')}}" class="pull-right">
                                    Forgot Password?
                                </a>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input type="checkbox" id="remember" name="remember"
                                                   value="true" {{ old('remember') ? 'checked' : '' }}>
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
                                <a href="/register">Don't have any account? Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
