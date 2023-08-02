@extends('Admin.inc.master')

@section('title')
    Create Role
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Role</h1>
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

                        <a href="{{ route('admin.roles.index') }}" class='btn btn-primary mb-4 '>Back To Role</a>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mg-b-20">
                                        <div class="card-body">
                                            <div class="main-content-label mg-b-5">
                                                <div class="col-xs-7 col-sm-7 col-md-7">
                                                    <div class="form-group">
                                                        <p>Name</p>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ old('name') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <ul id="treeview1">
                                                        <li><a href="#">Permissions</a>
                                                            <ul>
                                                                @foreach ($permissions as $permission)
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input"
                                                                            name="permission[]" value="{{ $permission->id }}">
                                                                        <span
                                                                            class="custom-control-label">{{ $permission->name }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>


                                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
