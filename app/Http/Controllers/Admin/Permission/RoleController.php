<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Http\Traits\RedirectTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    use RedirectTrait;

    public function __construct()
    {
        $this->middleware("permission:view role", ["only" => ["index", "show"]]); 
        $this->middleware("permission:add role", ["only" => ["create", "store"]]);
        $this->middleware("permission:edit role", ["only" => ["edit", "update"]]);
        $this->middleware("permission:delete role", ["only" => "destroy"]);
    }


    public function index()
    {
        $roles = Role::get();
        return view('Admin.pages.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('Admin.pages.roles.show', compact('role', 'rolePermissions'));
    }

    public function create()
    {
        $permissions = Permission::get();
        return view('Admin.pages.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permission); //add permission for role in pivot table - argument : array of ids of permissions

        return $this->redirect("Role created successfully", "admin.roles.index");

    }

    public function edit(Role $role)
    {
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all(); 
        return view('Admin.pages.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {

        $role->update([
            "name" => $request->name,
        ]);

        $role->syncPermissions($request->permission); 

        return $this->redirect("Role Updated successfully", "admin.roles.index");

    }

    public function destroy(Request $request)
    {
        $role = Role::findOrfail($request->role_id);
        $role->delete();
        return $this->redirect("Role Deleted successfully", "admin.roles.index");
    }
}
