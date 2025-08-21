<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;

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

    public function ImportPermission(){
        return view('admin.backend.pages.permission.import_permission');
     }

    public function Export(){
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request){

        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->back()->with($notification);
    }

    
}