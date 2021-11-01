@extends('layouts.mainApp')
@section('title', 'Profile')
@section('content')
    <div class="container">
        <div style="padding: 80px 0;">
            <form action="{{ route('logout') }}" method="get">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
@endsection
