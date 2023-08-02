@extends('Admin.inc.master')

@section('title')
    Partial Paid Invoices
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Partial Paid Invoices</h1>
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
                <a href="{{ route('admin.invoices.create') }}" class='btn btn-primary m-1 '>Add New Invoice</a>
                
                {{-- table --}}
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>invoice_number</th>
                                <th>invoice_date</th>
                                <th>due_date</th>
                                <th>section</th>
                                <th>product</th>
                                <th>Amount_Collection</th>
                                <th>Amount_Commission</th>
                                <th>discount</th>
                                <th>rate_vat</th>
                                <th>total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td><a
                                        href="{{ route('admin.invoices.show', $invoice) }}">{{ $invoice->section->name }}</a>
                                    </td>
                                    <td>{{ $invoice->product }}</td>
                                    <td>{{ $invoice->amount_collection }}</td>
                                    <td>{{ $invoice->amount_commission }}</td>
                                    <td>{{ $invoice->discount }}</td>
                                    <td>{{ $invoice->rate_vat }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>
                                        @if ($invoice->value_status == 1)
                                            <span class="text-success">{{ $invoice->status }}</span>
                                        @elseif($invoice->value_status == 2)
                                            <span class="text-danger">{{ $invoice->status }}</span>
                                        @else
                                            <span class="text-warning">{{ $invoice->status }}</span>
                                        @endif
                                    </td>

                                    <td>


                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                type="button">Actions<i class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13">

                                                @can('edit invoice')
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.invoices.edit', $invoice) }}">
                                                    <i class="far fa-edit"></i>&nbsp;&nbsp;Edit Invoice
                                                </a>
                                            @endcan


                                            @can('delete Invoice')
                                                <a class="dropdown-item" href="#"
                                                    data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                    data-target="#delete_invoice"><i
                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;Delete
                                                    Invoice
                                                </a>
                                            @endcan


                                            @can('change payment status')
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.details.edit_status', $invoice) }}"><i
                                                        class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;
                                                    Change Payment Status
                                                </a>
                                            @endcan

                                            @can('move to archive')
                                                <a class="dropdown-item" href="#"
                                                    data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                    data-target="#Transfer_invoice"><i
                                                        class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;
                                                    Move To Archive
                                                </a>
                                            @endcan

                                            @can('print invoice')
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.invoices.print', $invoice) }}"><i
                                                        class="text-success fas fa-print"></i>&nbsp;&nbsp;
                                                    Print Invoice
                                                </a>
                                            @endcan

                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Delete Modla-->
                <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete Invoice</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>


                                <form action="{{ route('admin.invoices.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                            </div>
                            <div class="modal-body">
                                Are You Sure From Delete Invoice ?
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Confirm</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!--Invoice Archive-->
                <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Invoice Archive </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{ route('admin.invoices.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                            </div>
                            <div class="modal-body">
                                Are You Sure From Archiving ?
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                {{-- عشان اميز الارشيف عن الحذف ف الكنترولر --}}
                                <input type="hidden" name="id_page" id="id_page" value="2">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Confirm</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </section>

        {{-- {{ $products->links() }} --}}

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
