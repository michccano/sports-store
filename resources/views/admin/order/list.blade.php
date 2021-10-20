@extends('layouts.admin')

@section('title', 'Orders List')

@section('styles')
    <link rel="stylesheet" href="/theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-10">
                        <p id="message" class=""></p>
                        <a href="{{route("refundView")}}" class="btn btn-info">Refund</a>
                    </div><!-- /.col -->
                    <div class="col-sm-2">

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Orders List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="order_dataTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Total Bill</th>
                                        <th>Card Payment</th>
                                        <th>Token Payment</th>
                                        <th>Card</th>
                                        <th>Transaction Id</th>
                                        <th>Transaction Reference</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>

@endsection
@section('scripts')
    <script src="/theme/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/theme/plugins/jszip/jszip.min.js"></script>
    <script src="/theme/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/theme/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function() {
            $('#order_dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('getOrders') }}",
                columns: [
                    {
                        data: 'invoice',
                        name: 'invoice'
                    },
                    {
                        data: 'total_bill',
                        name: 'total_bill'
                    },
                    {
                        data: 'card_payment_amount',
                        name: 'card_payment_amount',
                    },
                    {
                        data: 'token_payment_amount',
                        name: 'token_payment_amount'
                    },
                    {
                        data: 'cardNumber',
                        name: 'cardNumber'
                    },
                    {
                        data: 'transactionId',
                        name: 'transactionId'
                    },
                    {
                        data: 'transactionReference',
                        name: 'transactionReference'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
