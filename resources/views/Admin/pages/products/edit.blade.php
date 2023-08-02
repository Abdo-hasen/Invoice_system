@extends('Admin.inc.master')

@section('title')
    Edit Product
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Product</h1>
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

                <a href="{{ route("admin.products.index") }}" class='btn btn-primary mb-4 ' >Back To Products</a>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Product</h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- form start -->
                    <form action="{{ route("admin.products.update", $product) }}" method="post">
                        @method("put")
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ old("name") ?? $product->name }}" class="form-control" placeholder="Enter Product Name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description"  class="form-control" placeholder="Enter Product Description">{{ old("description") ?? $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Section</label>
                                <select class="form-control" name="section_id">
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @selected($section->id == $product->section_id)>{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection


{{-- 
 <input type="text" name="name" value="{{ old("name") ?? $product->name }}"  : 
 لو في old زي حاجه غلط ف الفالديشن عيعرضها 
 واول ميدخل هيعرضلك قديم عشان تعدل عليه    
--}}