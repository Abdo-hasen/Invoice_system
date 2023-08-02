@extends('Admin.inc.master')

@section('title')
    Products
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products</h1>
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
                {{-- @dd($sections) - dd(var not var name) --}}
                @can('add products')
                    <a href="{{ route('admin.products.create') }}" class='btn btn-primary m-1 '>Add New Product</a>
                @endcan

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>name</th>
                                <th>description</th>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->section->name }}</td>
                                    <td>
                                        @can('edit products')
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="btn btn-primary">Edit</a>
                                        @endcan

                                        @can('delete products')
                                            <form method="post" action=" {{ route('admin.products.destroy', $product) }} "
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </section>

        {{ $products->links() }}

    </div>
    <!-- /.content-wrapper -->
@endsection
