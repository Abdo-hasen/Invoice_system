@extends('Admin.inc.master')

@section('title')
    Edit Invoices
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Invoices</h1>
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

                        <form action="{{ route('admin.invoices.update', $invoice) }}" method="post"
                            enctype="multipart/form-data" autocomplete="off">
                            @method('put')
                            @csrf

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoice_number" id="inputName"
                                        placeholder="Enter Invoice Number"
                                        value="{{ old('invoice_number') ?? $invoice->invoice_number }}" required>
                                </div>

                                <div class="col">
                                    <label>Invoice Date</label>
                                    <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                        type="text" value="{{ date('Y-m-d') }}"
                                        value="{{ old('invoice_date') ?? $invoice->invoice_date }}" required>
                                </div>

                                <div class="col">
                                    <label>Due Date</label>
                                    <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                        type="text" value="{{ old('due_date') ?? $invoice->due_date }}" required>
                                </div>

                            </div>

                            {{-- 2 --}}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Section</label>
                                    <select name="section_id" class="form-control SlectBox"
                                        onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                        <!--placeholder-->
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" @selected($section->id == $invoice->section_id)>
                                                {{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col">
                                    <label>Product</label>
                                    <select class="form-control" name="product">
                                        <option value="{{ $invoice->product }}">
                                            {{ $invoice->product }}</option>
                                    </select>
                                </div>



                                <div class="col">
                                    <label for="inputName" class="control-label">Amount Collection</label>
                                    <input type="text" class="form-control" name="amount_collection"
                                        value="{{ old('amount_collection') ?? $invoice->amount_collection }}"
                                        id="Amount_Commission"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>


                            {{-- 3 --}}

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">Amount Commission</label>
                                    <input type="text" class="form-control form-control-lg" name="amount_commission"
                                        value="{{ old('amount_commission') ?? $invoice->amount_commission }}"
                                        title="Enter Amount Commission"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Discount</label>
                                    <input type="text" class="form-control form-control-lg" name="discount"
                                        title="Enter The Discount" id="Discount"
                                        value="{{ old('discount') ?? $invoice->discount }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        value=0 required>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Rate Vat</label>
                                    <select name="rate_vat" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                        <!--placeholder-->
                                        <option value="{{ $invoice->rate_vat }}">
                                            {{ $invoice->rate_vat }}</option>
                                        <option value=" 5%">5%</option>
                                        <option value="10%">10%</option>
                                    </select>
                                </div>

                            </div>

                            {{-- 4 --}}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Value VAT</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('value_vat') ?? $invoice->value_vat }}" name="value_vat"
                                        id="Value_VAT" readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Total</label>
                                    <input type="text" class="form-control" name="total"
                                        value="{{ old('total') ?? $invoice->total }}" id="Total" readonly>
                                </div>
                            </div>

                            {{-- 5 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="exampleTextarea">note</label>
                                    <textarea class="form-control" name="note" id="exampleTextarea" rows="3">{{ old('note') ?? $invoice->note }}</textarea>
                                </div>
                            </div><br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Update Invoice</button>
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

    <script>
        function myFunction() {

            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);

            var Amount_Commission2 = Amount_Commission - Discount;


            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {

                alert('Please Enter Amount Commission');

            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("Value_VAT").value = sumq;

                document.getElementById("Total").value = sumt;

            }

        }
    </script>

    <script>
        $(document).ready(function() {
            $('select[name="section_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('admin/invoices/section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>
@endsection
