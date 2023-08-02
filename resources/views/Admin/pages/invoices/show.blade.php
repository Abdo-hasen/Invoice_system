    @extends('Admin.inc.master')

    @section('title')
        Show Details
    @endsection


    {{-- @section('css')
        ###
    @endsection --}}


    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Show Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- row opened -->
                    <div class="row row-sm">

                        <div class="col-xl-12">
                            <!-- div -->
                            <div class="card mg-b-20" id="tabs-style2">
                                <div class="card-body">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <div class="panel panel-primary tabs-style-2">
                                                <div class=" tab-menu-heading">
                                                    <div class="tabs-menu1">
                                                        <!-- Tabs -->
                                                        <ul class="nav panel-tabs main-nav-line">
                                                            <li><a href="#tab4" class="nav-link active"
                                                                    data-toggle="tab">Invoice Details
                                                                </a></li>
                                                            <li><a href="#tab5" class="nav-link"
                                                                    data-toggle="tab">Status</a>
                                                            </li>
                                                            <li><a href="#tab6" class="nav-link"
                                                                    data-toggle="tab">Attachments</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                                    <div class="tab-content">

                                                        <div class="tab-pane active" id="tab4">
                                                            <div class="table-responsive mt-15">

                                                                <table class="table table-striped"
                                                                    style="text-align:center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">invoice number </th>
                                                                            <td>{{ $invoice->invoice_number }}</td>
                                                                            <th scope="row">invoice Date </th>
                                                                            <td>{{ $invoice->invoice_date }}</td>
                                                                            <th scope="row">Due_date </th>
                                                                            <td>{{ $invoice->due_date }}</td>
                                                                            <th scope="row">Section</th>
                                                                            <td>{{ $invoice->section->name }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="row">Product</th>
                                                                            <td>{{ $invoice->product }}</td>
                                                                            <th scope="row">Amount collection </th>
                                                                            <td>{{ $invoice->amount_collection }}</td>
                                                                            <th scope="row">Amount_Commission </th>
                                                                            <td>{{ $invoice->amount_commission }}</td>
                                                                            <th scope="row">Discount</th>
                                                                            <td>{{ $invoice->discount }}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <th scope="row">Rate_VAT </th>
                                                                            <td>{{ $invoice->rate_vat }}</td>
                                                                            <th scope="row">Value_VAT </th>
                                                                            <td>{{ $invoice->value_vat }}</td>
                                                                            <th scope="row"> Total </th>
                                                                            <td>{{ $invoice->total }}</td>
                                                                            <th scope="row"> Current Satus </th>

                                                                            @if ($invoice->value_status == 1)
                                                                                <td><span
                                                                                        class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                                                </td>
                                                                            @elseif($invoice->value_status == 2)
                                                                                <td><span
                                                                                        class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                                                </td>
                                                                            @else
                                                                                <td><span
                                                                                        class="badge badge-pill badge-warning">{{ $invoice->Status }}</span>
                                                                                </td>
                                                                            @endif
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="row">Notes</th>
                                                                            <td>{{ $invoice->note }}</td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>


                                                        <div class="tab-pane" id="tab5">
                                                            <div class="table-responsive mt-15">
                                                                <table class="table center-aligned-table mb-0 table-hover"
                                                                    style="text-align:center">
                                                                    <thead>
                                                                        <tr class="text-dark">
                                                                            <th>#</th>
                                                                            <th>Invoice Number </th>
                                                                            <th> Product</th>
                                                                            <th>Section</th>
                                                                            <th> Status</th>
                                                                            <th> Payment Date </th>
                                                                            <th>Notes</th>
                                                                            <th> Created at </th>
                                                                            <th>User</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        @foreach ($invoice->details as $detail)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $detail->invoice_number }}</td>
                                                                                <td>{{ $detail->product }}</td>
                                                                                <td>{{ $invoice->section->name }}</td>
                                                                                @if ($detail->value_status == 1)
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-success">{{ $detail->status }}</span>
                                                                                    </td>
                                                                                @elseif($detail->value_status == 2)
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-danger">{{ $detail->status }}</span>
                                                                                    </td>
                                                                                @else
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-warning">{{ $detail->status }}</span>
                                                                                    </td>
                                                                                @endif
                                                                                <td>{{ $detail->payment_date }}</td>
                                                                                <td>{{ $detail->note }}</td>
                                                                                <td>{{ $detail->created_at }}</td>
                                                                                <td>{{ $detail->user }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>


                                                            </div>
                                                        </div>


                                                        <div class="tab-pane" id="tab6">
                                                            <!--Attachemts-->
                                                            <div class="card card-statistics">
                                                                <div class="card-body">
                                                                    <p class="text-danger">Attachments Types : pdf, jpeg
                                                                        ,.jpg , png </p>
                                                                    <h5 class="card-title"> Add Attachments</h5>
                                                                    <form method="post"
                                                                        action="{{ route('admin.attachments.store') }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                id="customFile" name="file" required>
                                                                            <input type="hidden" id="customFile"
                                                                                name="invoice_number"
                                                                                value="{{ $invoice->invoice_number }}">
                                                                            <input type="hidden" id="invoice_id"
                                                                                name="invoice_id"
                                                                                value="{{ $invoice->id }}">
                                                                            <label class="custom-file-label"
                                                                                for="customFile">Choose File
                                                                            </label>
                                                                        </div><br><br>
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm "
                                                                            name="uploadedFile">Confirm</button>
                                                                    </form>
                                                                </div>
                                                                <br>

                                                                <div class="table-responsive mt-15">
                                                                    <table
                                                                        class="table center-aligned-table mb-0 table table-hover"
                                                                        style="text-align:center">
                                                                        <thead>
                                                                            <tr class="text-dark">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">File Name </th>
                                                                                <th scope="col"> Created by</th>
                                                                                <th scope="col">Created at </th>
                                                                                <th scope="col">Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; ?>
                                                                            @foreach ($invoice->attachments as $attachment)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $attachment->file_name }}
                                                                                    </td>
                                                                                    <td>{{ $attachment->created_by }}
                                                                                    </td>
                                                                                    <td>{{ $attachment->created_at }}
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        @can('view file')
                                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                                href="{{ route('admin.attachments.open_file', $attachment) }}"
                                                                                                {{-- href="{{ url('admin/attachments/open_file') }}/{{ $invoice->invoice_number }}/ {{ $attachment->file_name  }}" --}}
                                                                                                role="button"><i
                                                                                                    class="fas fa-eye"></i>&nbsp;
                                                                                                View File</a>
                                                                                        @endcan

                                                                                        @can('download file')
                                                                                            <a class="btn btn-outline-info btn-sm"
                                                                                                href="{{ route('admin.attachments.download_file', $attachment) }}"
                                                                                                role="button"><i
                                                                                                    class="fas fa-download"></i>&nbsp;
                                                                                                Download File</a>
                                                                                        @endcan

                                                                                        @can('delete file')
                                                                                            <button
                                                                                                class="btn btn-outline-danger btn-sm"
                                                                                                data-toggle="modal"
                                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                                data-id_file="{{ $attachment->id }}"
                                                                                                data-target="#delete_file">Delete
                                                                                            </button>
                                                                                        @endcan
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /div -->
                        </div>

                    </div>
                    <!-- /row -->

                    <!-- delete modal -->
                    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Delete Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.attachments.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-body">
                                        <p class="text-center">
                                        <h6 style="color:rgb(80, 69, 69)"> Are You Sure From Deleting The Attachment? </h6>
                                        </p>
                                        {{-- make them text to confirm send data  --}}
                                        <input type="hidden" name="id_file" id="id_file" value="">
                                        <input type="hidden" name="file_name" id="file_name" value="">
                                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container closed -->
        </div>
        <!-- main-content closed -->

        </div>
        </section>
        </div>
        <!-- /.content-wrapper -->
    @endsection

    @section('js')
        <script>
            $('#delete_file').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id_file = button.data('id_file')
                var file_name = button.data('file_name')
                var invoice_number = button.data('invoice_number')
                var modal = $(this)

                modal.find('.modal-body #id_file').val(id_file);
                modal.find('.modal-body #file_name').val(file_name);
                modal.find('.modal-body #invoice_number').val(invoice_number);
            })
        </script>

        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>
    @endsection
