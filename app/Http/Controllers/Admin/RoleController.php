<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // Display all permissions.
    public function AllPermission(){
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.all_permission',compact('permissions'));
    }

    // Show the form to add a new permission.
    public function AddPermission(){
        return view('admin.backend.pages.permission.add_permission');
    }

    // Store a newly created permission in the database.
    public function StorePermission(Request $request){
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'guard_name' => 'admin'
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    // Show the form for editing the specified permission.
    public function EditPermission($id){
        $permission = Permission::find($id);
        return view('admin.backend.pages.permission.edit_permission',compact('permission'));
    }  

    // Update the specified permission in the database.
    public function UpdatePermission(Request $request){
        $per_id = $request->id;

        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name, 
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    // Remove the specified permission from the database.
    public function DeletePermission($id){

        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Display the import permissions view.
     */
    public function ImportPermission(){
        return view('admin.backend.pages.permission.import_permission');
    }

    /**
     * Export permissions to an Excel file.
     */
    public function Export(){
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    /**
     * Import permissions from an Excel file.
     */
    public function Import(Request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = [
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Display a list of all roles.
     */
    public function AllRoles(){
        $roles = Role::all();
        return view('admin.backend.pages.role.all_roles', compact('roles'));
    }

    /**
     * Display the form to add a new role.
     */
    public function AddRoles(){
        return view('admin.backend.pages.role.add_roles');
    }

    /**
     * Store a new role in the database.
     */
    public function StoreRoles(Request $request){
        Role::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        $notification = [
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.roles')->with($notification);
    }

    /**
     * Display the form to edit an existing role.
     */
    public function EditRoles($id){
        $roles = Role::find($id);
        return view('admin.backend.pages.role.edit_roles', compact('roles'));
    }

    /**
     * Update an existing role in the database.
     */
    public function UpdateRoles(Request $request){
        $role_id = $request->id;
        Role::find($role_id)->update([
            'name' => $request->name
        ]);

        $notification = [
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.roles')->with($notification);
    }

    /**
     * Delete a role from the database.
     */
    public function DeleteRoles($id){
        Role::find($id)->delete();
        $notification = [
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Display the form to assign permissions to a role.
     */
    public function AddRolesPermission(){
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();
        return view('admin.backend.pages.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    /**
     * Store the assigned permissions for a role.
     */
    public function RolePermissionStore(Request $request){
        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permission);

        $notification = [
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.roles.permission')->with($notification);
    }

    /**
     * Display all roles with their assigned permissions.
     */
    public function AllRolesPermission(){
        $roles = Role::all();
        return view('admin.backend.pages.rolesetup.all_roles_permission', compact('roles'));
    }

    /**
     * Display the form to edit permissions for a role.
     */
    public function AdminEditRoles($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();
        return view('admin.backend.pages.rolesetup.edit_roles_permission', compact('role', 'permissions', 'permission_groups'));
    }

    /**
     * Update the assigned permissions for a role.
     */
    public function AdminRolesUpdate(Request $request, $id){
        $role = Role::find($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        $notification = [
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.roles.permission')->with($notification);
    }

    /**
     * Delete a role and its permissions.
     */
    public function AdminDelectRoles($id){
        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = [
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}