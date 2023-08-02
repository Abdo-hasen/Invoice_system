@extends('Admin.inc.master')

@section('title')
    Create Section
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Section</h1>
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
                
                <a href="{{ route("admin.sections.index") }}" class='btn btn-primary mb-4 ' >Back To Sections</a>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Section</h3>
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
                    <form action="{{ route("admin.sections.store") }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ old("name") }}" class="form-control" placeholder="Enter Section Name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description"  class="form-control" placeholder="Enter Section Description">{{ old("description") }}</textarea>
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
