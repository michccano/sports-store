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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->status ? "Active" : "Inactive"}}</td>
                                        <td>
                                            <div class="row">
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{route("editProduct",$product->id)}}">
                                                    <i class="far fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm" data-productid="{{$product->id}}"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                <!-- Delete Modal-->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Request</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                            <form action="{{route('deleteProduct')}}" method="get">

                                                <div class="modal-body">
                                                    <p>Select "Delete" below if you are ready to delete the product.</p>
                                                    <input type="hidden" name="product_id" id="product_id" value="">
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            })

            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var product_id = button.data('productid')
                var modal = $(this)
                modal.find('.modal-body #product_id').val(product_id);
            })
        });
    </script>
@endsection
