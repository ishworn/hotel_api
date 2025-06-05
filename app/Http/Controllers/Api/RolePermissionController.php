<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        return response()->json(Role::all());
    }

    public function show(Role $role)
    {
        return response()->json([
            'role' => $role->name,
            'permissions' => $role->permissions->pluck('name'),
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions);

        return response()->json([
            'message' => 'Permissions updated successfully.',
            'role' => $role->name,
            'permissions' => $role->permissions->pluck('name'),
        ]);
    }
}
