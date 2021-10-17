@extends('layouts.admin')

@section('title', 'Products List')

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
                    <a href="{{route("createProduct")}}" class="btn btn-info">Add Product</a>
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
                            <h3 class="card-title">Products List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="product_dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Weekly Price</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Delivery</th>
                                        <th>Expire Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                            <!-- Delete Modal-->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Request</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>

                                        <form action="" method="get">

                                            <div class="modal-body">
                                                <p>Select "Delete" below if you are ready to delete the product.</p>
                                                <input type="hidden" name="product_id" id="product_id" value="">
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button id="deleteP" type="" class="btn btn-danger" data-dismiss="modal">Delete</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
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
        $('#product_dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('getProducts') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description',
                    render: function(data, type, full, meta) {
                        var html = data;
                        var div = document.createElement("div");
                        div.innerHTML = html;
                        htmlContent = div.textContent || div.innerText || "";
                        htmlToText =  $(htmlContent).text()
                        return htmlToText.split(/\s+/).slice(0,5).join(" ");
                    }
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'weekly_price',
                    name: 'weekly_price'
                },
                {
                    data: 'img',
                    name: 'img',
                    render: function(data, type, full, meta) {
                        return "<img src={{ URL::to('/') }}/images/" + data + " width='70' class='img-thumbnail' />";
                    }
                },
                {
                    data: 'category',
                    name: 'category',
                    render: function(data, type, full, meta) {
                        return data.name

                    }
                },
                {
                    data: 'delivery_method',
                    name: 'delivery_method'
                },
                {
                    data: 'expire_date',
                    name: 'expire_date'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        if (data == 1)
                            return "Active"
                        else
                            return "Inactive"

                    }
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
    $(function() {
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_id = button.data('productid')
            var modal = $(this)
            modal.find('.modal-body #product_id').val(product_id);
        })
    });

    $('#deleteP').click(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var product_id = $('#product_id').val();

        $.ajax({
            url: 'delete',
            data: {
                "product_id": product_id
            },
            type: 'POST',
            success: function(data) {
                $('#product_dataTable').DataTable().ajax.reload();
            },
            error: function() {}
        });
    });
</script>
@endsection
