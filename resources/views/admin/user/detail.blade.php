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
                                        <div class="col-md-8 g-5">
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
                                                        <td>{{$user->dayphone}}</td>
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
                                                            <td id="suspend1">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <p>No</p>
                                                                    </div>
                                                                    <button onclick="suspend1({{$user->id}})" class="btn btn-danger btn-xs">Suspend</button>
                                                                </div>
                                                            </td>
                                                            <td id="unsuspend1">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <p>Yes</p>
                                                                    </div>
                                                                    <button onclick="unsuspend1({{$user->id}})" class="btn btn-success btn-xs">Unsuspend</button>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td id="suspend2">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <p>No</p>
                                                                    </div>
                                                                    <button onclick="suspend2({{$user->id}})" class="btn btn-danger btn-xs">Suspend</button>
                                                                </div>
                                                            </td>
                                                            <td id="unsuspend2">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <p>Yes</p>
                                                                    </div>
                                                                    <button onclick="unsuspend2({{$user->id}})" class="btn btn-success btn-xs">Unsuspend</button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <b>Purchase Details :</b>
                                                <table class="table table-bordered table-striped">
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
                                                    <tr>
                                                        <td>
                                                            <a href="#" class="text-info">Purchase Picks History</a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="text-info">Purchase Store History</a>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="row">
                                                <b>Credit Card Details :</b>
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                    <tr>
                                                        <td>Card Type :</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Card Number :</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Card Expiration :</td>
                                                        <td></td>
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
@section('scripts')
    <script>
        $('#suspend2').hide();
        $('#unsuspend1').hide();

        function suspend1(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('suspendUser', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    if (data == 0){
                        $('#unsuspend1').show();
                        $('#suspend1').hide();
                    }
                },
                error: function () {
                }
            });
        }

        function unsuspend1(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('unsuspendUser', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    if (data == 1){
                        $('#unsuspend1').hide();
                        $('#suspend1').show();
                    }
                },
                error: function () {
                }
            });
        }

        function suspend2(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('suspendUser', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    if (data == 0){
                        $('#unsuspend2').show();
                        $('#suspend2').hide();
                    }
                },
                error: function () {
                }
            });
        }

        function unsuspend2(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('unsuspendUser', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    if (data == 1){
                        $('#unsuspend2').hide();
                        $('#suspend2').show();
                    }
                },
                error: function () {
                }
            });
        }
    </script>

@endsection
