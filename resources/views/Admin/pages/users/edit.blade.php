@extends('Admin.inc.master')

@section('title')
    Edit Users
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Edit Users
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

                        <a href="{{ route('admin.users.index') }}" class='btn btn-primary mb-4 '>Back To Users</a>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="parsley-style-1" autocomplete="off" action="{{ route('admin.users.update', $user) }}"
                        {{-- <form class="parsley-style-1" autocomplete="off" action="{{ route('admin.users.update', $user->id) }}" --}}
                            method="post">
                            @csrf
                            @method('put')

                            <div class="">
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6">
                                        <label>User Name </label>
                                        <input class="form-control form-control-sm mg-b-20" name="name" type="text"
                                            value="{{ old('name') ?? $user->name }}">
                                    </div>

                                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                        <label>Email</label>
                                        <input class="form-control form-control-sm mg-b-20" name="email" type="email"
                                            value="{{ old('email') ?? $user->email }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                    <label>Password</label>
                                    <input class="form-control form-control-sm mg-b-20" name="password" type="password"
                                        value="{{ old('password') }}" placeholder="optional">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label> Confirm Password </label>
                                    <input class="form-control form-control-sm mg-b-20" name="confirm_password"
                                        type="password" value="{{ old('confirm_password') }}" placeholder="optional">
                                </div>
                            </div>

                            <div class="row row-sm mg-b-20">
                                <div class="col-lg-6">
                                    <label class="form-label">STATUS </label>
                                    <select name="status" id="select-beast"
                                        class="form-control  nice-select  custom-select">
                                        <option value="{{ $user->status }}"> {{ $user->status }} </option>
                                        <option value="active">active</option>
                                        <option value="disable">disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label"> User Role </label>
                                        <select name="roles_name[]" class="form-control" multiple>
                                            @foreach ($user_role as $role)
                                                <option value="{{ $role }}" selected>{{ $role }}</option>
                                            @endforeach
                                            @foreach ($roles as $role)
                                                @if (!in_array($role, $user_role))
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
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
