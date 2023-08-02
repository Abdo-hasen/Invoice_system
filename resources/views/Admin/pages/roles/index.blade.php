@extends('Admin.inc.master')

@section('title')
    Users Roles
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Users Roles
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

        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    @can('add role')
                                        <a class="btn btn-primary m-1 " href="{{ route('admin.roles.create') }}">Add New
                                            Role</a>
                                    @endcan
                                </div>
                            </div>
                            <br>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap table-hover ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @can('view role')
                                                    <a class="btn btn-success "
                                                        href="{{ route('admin.roles.show', $role) }}">Show</a>
                                                @endcan

                                                @can('edit role')
                                                    <a class="btn btn-primary "
                                                        href="{{ route('admin.roles.edit', $role) }}">Edit</a>
                                                @endcan

                                                @can('delete role')
                                                    <a href="#" data-role_id="{{ $role->id }}" data-toggle="modal"
                                                        data-target="#delete_role" class="btn btn-danger "> Delete Role</a>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <!-- Delete Modla-->
                            <div class="modal fade" id="delete_role" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>


                                            <form action="{{ route('admin.roles.destroy') }}" method="post">
                                                @csrf
                                                @method('delete')
                                        </div>
                                        <div class="modal-body">
                                            Are You Sure From Delete Role ?
                                            <input type="hidden" name="role_id" id="role_id" value="">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Confirm</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <script>
        $('#delete_role').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var role_id = button.data('role_id')
            var modal = $(this)
            modal.find('.modal-body #role_id').val(role_id);
        })
    </script>
@endsection
