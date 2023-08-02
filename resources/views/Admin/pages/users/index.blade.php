@extends('Admin.inc.master')

@section('title')
    Users
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="col-sm-1 col-md-2">
                            @can('add user')
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.users.create') }}"> Add User</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive hoverable-table">
                            <table class="table table-hover" id="example1" data-page-length='50'
                                style=" text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="wd-10p border-bottom-0">#</th>
                                        <th class="wd-15p border-bottom-0">Username </th>
                                        <th class="wd-20p border-bottom-0"> Email</th>
                                        <th class="wd-15p border-bottom-0"> User Status</th>
                                        <th class="wd-15p border-bottom-0"> User Role</th>
                                        <th class="wd-10p border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->status == 'active')
                                                    <span class="label text-success d-flex">
                                                        <div class="dot-label bg-success ml-1"></div>{{ $user->status }}
                                                    </span>
                                                @else
                                                    <span class="label text-danger d-flex">
                                                        <div class="dot-label bg-danger ml-1"></div>{{ $user->status }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <label class="badge badge-success">{{ $role }}</label>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>

                                                @can('show user')
                                                    <a class="btn btn-sm btn-success "
                                                        href="{{ route('admin.users.show', $user) }}">Show</a>
                                                @endcan

                                                @can('edit user')
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info"
                                                        title="Edit"><i class="las la-pen">Edit</i></a>
                                                @endcan



                                                @can('delete user')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                                        data-toggle="modal" href="#modaldemo8" title="Delete"><i
                                                            class="las la-trash"></i>Delete</a>
                                                @endcan


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->

            <!-- Modal effects -->
            <div class="modal" id="modaldemo8">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">Delete User </h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('admin.users.destroy') }}" method="post">
                            @method('delete')
                            @csrf
                            <div class="modal-body">
                                <p> Are You Sure From Deleting </p>
                                </p><br>
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <input class="form-control" name="username" id="username" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Confirm</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->


    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })
    </script>
@endsection
