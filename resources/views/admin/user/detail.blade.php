@extends('layouts.admin')

@section('title', 'Member Details')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Member Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <b>Member Details :</b>
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                    <tr>
                                                        <td>Firts Name :</td>
                                                        <td>{{$user->firstname}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Name :</td>
                                                        <td>{{$user->lastname}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email :</td>
                                                        <td>{{$user->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address1 :</td>
                                                        <td>{{$user->address1}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address2 :</td>
                                                        <td>{{$user->address2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>City :</td>
                                                        <td>{{$user->city}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>State :</td>
                                                        <td>{{$user->state}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Postal Code :</td>
                                                        <td>{{$user->postal}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country :</td>
                                                        <td>{{$user->country}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dayphone :</td>
                                                        <td>{{$user->dayphoney}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Evephone :</td>
                                                        <td>{{$user->evephone}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country :</td>
                                                        <td>{{$user->country}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Suspended :</td>
                                                        @if($user->status == 1)
                                                            <td>No</td>
                                                        @else
                                                            <td>Yes</td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <b>Purchase Details :</b>
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                    <tr>
                                                        <td>Current Purchase Count:</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Purchases :</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Current Level :</td>
                                                        <td>{{$user->level}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                <tr>
                                                    <td>0:Has registered.
                                                        Information not verified.
                                                        Can Get PAW Picks.</td>
                                                </tr>
                                                <tr>
                                                    <td>1: NOT Verified Or Had Error on First Purchase
                                                        Can NOT Purchase.</td>
                                                </tr>
                                                <tr>
                                                    <td>2: Has Been Verified.
                                                        Can Purchase 7 picks in a 7 day period.
                                                        After 90 days & 48 clean purhcases and upon review will be graduated to level 3.</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        3: Has Been Verified.
                                                        Can Purchase 14 picks in a 7 day period.
                                                        After 180 days & 96 clean purhcases and upon review will be graduated to level
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        4: Has Been Verified.
                                                        Can Purchase 21 picks in a 7 day period.
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <a href="#">Clear Current Purchases
                                                            (Clears Order Count)</a>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

