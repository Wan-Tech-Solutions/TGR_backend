<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\Role;


class AdminRolesController extends Controller
{
    //
    public function roles(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $roles = Role::orderby('created_at','desc')->paginate(15);


        return view('adminPortal.roles.roles',compact('count_blogs','contact_count','founder_count','prospectus_count','roles'));
    }

    public function edit($id){
        try {
            $role = Role::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        try {
            $role = Role::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'guard_name' => 'required|string|max:255',
            ]);

            $role->name = $validated['name'];
            $role->guard_name = $validated['guard_name'];
            $role->save();

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'data' => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPermissions($id){
        try {
            $role = Role::with('permissions')->findOrFail($id);
            $allPermissions = \App\Models\Permission::orderBy('group_name')->orderBy('name')->get();
            
            // Group permissions by group_name
            $groupedPermissions = $allPermissions->groupBy('group_name');
            
            // Get role's permission IDs
            $rolePermissionIds = $role->permissions->pluck('id')->toArray();
            
            return response()->json([
                'success' => true,
                'role' => $role,
                'groupedPermissions' => $groupedPermissions,
                'rolePermissionIds' => $rolePermissionIds
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found: ' . $e->getMessage()
            ], 404);
        }
    }
}
