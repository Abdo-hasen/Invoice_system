@extends('Admin.inc.master')

@section('title')
    Print Invoice
@endsection

{{-- to exciude vutton print from printing --}}
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Print Invoice
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


 <!-- row -->
 <div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice" id="print">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">Invoice </h1>
                        <div class="billed-from">
                            <h6>BootstrapDash, Inc.</h6>
                            <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                Tel No: 324 445-4544<br>
                                Email: abdohasen@gmail.com</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <label class="tx-gray-600">Billed To</label>
                            <div class="billed-to">
                                <h6>Juan Dela Cruz</h6>
                                <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                    Tel No: 324 445-4544<br>
                                    Email: mohamed@laravel.com</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">Invoice Information : </label>
                            <br>
                            <p class="invoice-info-row"><span>invoice number : </span>
                                <span>{{ $invoice->invoice_number }}</span></p>
                            <p class="invoice-info-row"><span>invoice Date : </span>
                                <span>{{ $invoice->invoice_date }}</span></p>
                            <p class="invoice-info-row"><span> Due date :</span>
                                <span>{{ $invoice->due_date }}</span></p>
                            <p class="invoice-info-row"><span>Section :</span>
                                <span>{{ $invoice->section->name }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">Product</th>
                                    <th class="tx-center"> Amount collection</th>
                                    <th class="tx-left"> Amount Commission</th>
                                    <th class="tx-left">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">{{ $invoice->product }}</td>
                                    {{-- بتحط واو بعد رقمين --}}
                                    <td class="tx-center">{{ number_format($invoice->amount_collection,2) }}</td>
                                    <td class="tx-left">{{ number_format($invoice->amount_commission, 2) }}</td>
                                    @php
                                        $total = $invoice->amount_collection + $invoice->amount_commission;
                                    @endphp
                                    <td class="tx-left">
                                        {{ number_format($total, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">#</label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tx-left"> Rate Vat ({{ $invoice->rate_vat }})</td>
                                    <td class="tx-left" colspan="2">287.50</td>
                                </tr>
                                <tr>
                                    <td class="tx-left">Discount </td>
                                    <td class="tx-left" colspan="2"> {{ number_format($invoice->discount, 2) }}</td>

                                </tr>
                                <tr>
                                    <td class="tx-left tx-uppercase tx-bold tx-inverse"> Total With Vat </td>
                                    <td class="tx-left" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{ number_format($invoice->total, 2) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">



                    <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                            class="mdi mdi-printer ml-1"></i>Print</button>
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

@endsection

@section('js')
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
