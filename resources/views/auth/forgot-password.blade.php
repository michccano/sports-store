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
                        <form method="POST" class="my-login-validation" novalidate="" action="{{ route('password.email') }}">
                            @csrf

                            @if (session('status'))
                                <p class="alert alert-ssuccess">
                                    {{ session('status') }}
                                </p>
                            @endif
                            <div class="card-body">
                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                            </div>
                            </div>

                            <div class="card-footer">
                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Send Password Link
                                </button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
