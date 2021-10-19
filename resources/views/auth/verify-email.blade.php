@extends('layouts.auth')

@section('title', 'Verify Email')

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
                            <h3 class="card-title">Verify Email</h3>
                        </div>
                        <div class="card-body">
                            @if (session('message'))
                                <p class="alert alert-success">
                                    {{ session('message') }}
                                </p>
                            @endif
                            <p>
                                Check your email and click on the given link to verify your email address.
                                If you don't get the email click the resend link below.
                            </p>
                                <form action="{{route('verification.send')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-info">Resend</button>
                                </form>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
