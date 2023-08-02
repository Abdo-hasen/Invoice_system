@extends('Admin.inc.master')

@section('title')
    Edit Roles
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Roles</h1>
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

                        <a href="{{ route('admin.roles.index') }}" class='btn btn-primary mb-4 '>Back To Roles</a>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old("name") ?? $role->name }}">
                            </div>

                            <div class="form-group">
                                <label for="permissions">Permissions</label>
                                <ul>
                                    @foreach ($permissions as $permission)
                                        <li>
                                            <label>
                                                <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                {{ $permission->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
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


{{-- 
    
// من الاخر يعني اعملي تشيك ع الصلاحيات بتاعته القديمه 
؟ : ternary operator 
    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>

- The ternary operator (? :) is a shorthand way of writing an if/else statement. Here's an example:

// Using the ternary operator : if/else
$age = 18;
$canVote = ($age >= 18) ? true : false;
echo $canVote; // Prints 'true'


- The null coalescing operator (??) is used to assign a default value to a variable if it is null. Here's an example:
// Using the null coalescing operator : or
$name = null;
$defaultName = 'John Doe';
$fullName = $name ?? $defaultName;
echo $fullName; // Prints 'John Doe'
--}}