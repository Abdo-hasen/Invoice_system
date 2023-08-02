@extends('Admin.inc.master')

@section('title')
    Dashboard
@endsection



@section('content')
    @php
        use App\Models\Invoice;
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">


                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h4>All Invoices </h4>
                                <h3>sum : {{ $sum }}</h3>
                                <h3>count : {{ $count }}</h3>
                                <h3>100<sup style="font-size: 20px">%</sup></h3>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <div class="inner">
                                    <h4>Paid Invoices </h4>
                                    <h3>sum : {{ $paid_sum }}</h3>
                                    <h3>count : {{ $paid_count }}</h3>
                                    <h3>{{ round($paid_percentage) }}<sup style="font-size: 20px">%</sup>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->


                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h4>Partial Paid Invoices </h4>
                                <h3>sum : {{ $partial_sum }}</h3>
                                <h3>count : {{ $partial_count }}</h3>
                                <h3>{{ round($partial_percentage) }}<sup style="font-size: 20px">%</sup>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h4>UnPaid Invoices </h4>
                                <h3>sum : {{ $unpaid_sum }}</h3>
                                <h3>count : {{ $unpaid_count }}</h3>
                                <h3>{{ round($unpaid_percentage) }}<sup style="font-size: 20px">%</sup>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Invoices Statistics
                                </h3>
                            </div><!-- /.card-header -->


                            <div style="width:75%;">
                                {!! $chartjs->render() !!}
                            </div>
                        </div>
                        <!-- /.card -->

                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                        <!-- Map card -->
                        <div class="card">
                            <div class="card-header">
                                {{-- <div class="card bg-gradient-primary"> --}}
                                {{-- <div class="card-header border-0"> --}}
                                <h3 class="card-title">
                                    Invoices Statistics
                                </h3>
                            </div>
                            <div class="" style="width: 100%">
                                {!! $chartjs_2->render() !!}
                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
