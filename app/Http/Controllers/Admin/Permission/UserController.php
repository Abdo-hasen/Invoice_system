<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Traits\RedirectTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

class UserController extends Controller
{

    use RedirectTrait;

    public function __construct()
    {
        $this->middleware("permission:users list", ["only" => ["index", "show"]]); 
        $this->middleware("permission:add user", ["only" => ["create", "store"]]);
        $this->middleware("permission:edit user", ["only" => ["edit", "update"]]);
        $this->middleware("permission:delete user", ["only" => "destroy"]);
    }


    public function index()
    {
        $users = User::get();
        return view('Admin.pages.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('Admin.pages.users.show', compact('user'));
    }



    public function create()
    {
        $roles = Role::pluck('name')->all(); // get not work with pluck
        return view('Admin.pages.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "status" => $request->status,
            "role_name" => $request->roles_name,
        ]);

        $user->assignRole($request->roles_name); 

        return $this->redirect("User created successfully", "admin.users.index");

    }

   

    public function edit(User $user)
    {
        $roles = Role::pluck('name')->all();
        $user_role = $user->roles->pluck('name')->all();
        // dd($user_role);
        return view('Admin.pages.users.edit', compact('user', 'roles', 'user_role'));
    }


    public function update(UpdateUserRequest $request,User $user )
    {
       

        if (empty($request->password)) {
            $user->update([
                "name" => $request->name,
                "email" => $request->email,
                "status" => $request->status,
                "role_name" => $request->roles_name,
            ]);
        }else{
            $user->update([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "status" => $request->status,
                "role_name" => $request->roles_name,
            ]);
        }

        DB::table('model_has_roles')->where('model_id', $user->id)->delete(); 
        $user->assignRole($request->roles_name); 
        return $this->redirect("User updated successfully", "admin.users.index");

    }
   

    public function destroy(Request $request)
    {
         User::findOrfail(($request->user_id))->delete();
        return $this->redirect("User deleted successfully", "admin.users.index");
    }
}
