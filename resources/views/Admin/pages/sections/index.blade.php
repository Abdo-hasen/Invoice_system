@extends('Admin.inc.master')

@section('title')
    Sections
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sections</h1>
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

                @can('add section')
                    <a href="{{ route('admin.sections.create') }}" class='btn btn-primary m-1 '>Add New Section</a>
                @endcan

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>name</th>
                                <th>description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($sections as $section)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->description }}</td>
                                    <td>
                                        @can('edit section')
                                            <a href="{{ route('admin.sections.edit', $section) }}"
                                                class="btn btn-primary">Edit</a>
                                        @endcan

                                        @can('delete section')
                                            <form method="post" action=" {{ route('admin.sections.destroy', $section) }} "
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
    </div>
    <!-- /.content-wrapper -->
@endsection
