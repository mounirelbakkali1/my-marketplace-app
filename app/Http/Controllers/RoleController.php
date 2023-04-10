<?php

namespace App\Http\Controllers;

use App\Policies\RoleAndPermissionPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use function response;

class RoleController extends Controller
{

    protected RoleAndPermissionPolicy $roleAndPermissionPolicy;

    /**
 * @param RoleAndPermissionPolicy $roleAndPermissionPolicy
 */
    public function __construct(RoleAndPermissionPolicy $roleAndPermissionPolicy)
{
    $this->roleAndPermissionPolicy = $roleAndPermissionPolicy;
}




    public function index()
    {
        $this->authorize('view', [Auth::user(), 'roles']);
        $roles = Role::all();
        return response()->json([
            'status' => 'success',
            'message' => 'roles list',
            'roles' => $roles,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('add roles'))
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allowed to add roles',
            ], 403);
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
        $role = Role::create(['name' => $request->name]);
        return response()->json([
            'status' => 'success',
            'message' => 'role created successfully',
            'role' => $role,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
        ]);
        $role->update(['name' => $request->name]);
        return response()->json([
            'status' => 'success',
            'message' => 'role updated successfully',
            'role' => $role,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if(!Auth::user()->hasPermissionTo('delete roles'))
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allowed to delete roles',
            ], 403);
        $role->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'role deleted successfully',
        ], 200);
    }
}
