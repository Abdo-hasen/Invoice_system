@extends('Admin.inc.master')

@section('title')
    Edit Status
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
                        <h1 class="m-0"> Edit Status
                        </h1>
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
        <!-- row -->
        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('admin.invoices.index') }}" class='btn btn-primary mb-4 '>Back To Invoices</a>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.details.update_status', $invoice) }}" method="post"
                            enctype="multipart/form-data" autocomplete="off">
                            @method('put')
                            @csrf

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoice_number" id="inputName"
                                        placeholder="Enter Invoice Number" value="{{ $invoice->invoice_number }}" required
                                        readonly>
                                </div>

                                <div class="col">
                                    <label>Invoice Date</label>
                                    <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                        type="text" value="{{ date('Y-m-d') }}" value="{{ $invoice->invoice_date }}"
                                        required readonly>
                                </div>

                                <div class="col">
                                    <label>Due Date</label>
                                    <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                        type="text" value="{{ $invoice->due_date }}" required readonly>
                                </div>

                            </div>

                            {{-- 2 --}}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Section</label>
                                    <select name="section_id" class="form-control SlectBox"
                                        onclick="console.log($(this).val())" onchange="console.log('change is firing')"
                                        readonly>
                                        <!--placeholder-->
                                        <option value=" {{ $invoice->section_id }}">
                                            {{ $invoice->section->name }}
                                        </option>

                                    </select>
                                </div>


                                <div class="col">
                                    <label>Product</label>
                                    <select class="form-control" name="product" readonly>
                                        <option value="{{ $invoice->product }}">{{ $invoice->product }}
                                        </option>
                                    </select>
                                </div>



                                <div class="col">
                                    <label for="inputName" class="control-label">Amount Collection</label>
                                    <input type="text" class="form-control" name="amount_collection"
                                        value="{{ $invoice->amount_collection }}" readonly id="Amount_Commission"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>


                            {{-- 3 --}}

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">Amount Commission</label>
                                    <input type="text" class="form-control form-control-lg" name="amount_commission"
                                        value="{{ $invoice->amount_commission }}" title="Enter Amount Commission"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Discount</label>
                                    <input type="text" class="form-control form-control-lg" name="discount"
                                        title="Enter The Discount" id="Discount" value="{{ $invoice->discount }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        value=0 required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Rate Vat</label>
                                    <select name="rate_vat" id="Rate_VAT" class="form-control" onchange="myFunction()"
                                        readonly>
                                        <!--placeholder-->
                                        <option value="{{ $invoice->rate_vat }}">
                                            {{ $invoice->rate_vat }}</option>
                                    </select>
                                </div>

                            </div>

                            {{-- 4 --}}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Value VAT</label>
                                    <input type="text" class="form-control" value="{{ $invoice->value_vat }}"
                                        name="value_vat" id="Value_VAT" readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Total</label>
                                    <input type="text" class="form-control" name="total"
                                        value="{{ $invoice->total }}" id="total" readonly>
                                </div>
                            </div>

                            {{-- 5 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="exampleTextarea">note</label>
                                    <textarea class="form-control" name="note" readonly id="exampleTextarea" rows="3">{{ $invoice->note }}</textarea>
                                </div>
                            </div><br>



                            <div class="row">
                                <div class="col">
                                    <label for="exampleTextarea">Payment Status </label>
                                    <select class="form-control" id="Status" name="payment_status" required>
                                        <option selected="true" disabled="disabled">-- Choose Payment Status --</option>
                                        <option value="paid">Paid</option>
                                        <option value="partial paid"> Partial Paid </option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label>Payment Date </label>
                                    <input class="form-control fc-datepicker" name="payment_date"
                                        placeholder="YYYY-MM-DD" type="text" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div><br>


                            <div class="row">
                                <div class="col">
                                    <label>Partial Payment Amount</label>
                                    <input class="form-control" name="partial_payment_amount" type="number"
                                        id="partialPaymentAmount" >
                                </div>
                                <div class="col">
                                    <label>Remaining Balance</label>
                                    <input class="form-control" name="remaining_balance" type="number"
                                        id="remainingBalance" readonly>
                                </div>
                            </div><br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary"> Update Payment Status</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
@endsection
