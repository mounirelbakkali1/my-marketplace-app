<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use function response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $role->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'role deleted successfully',
        ], 200);
    }
}
