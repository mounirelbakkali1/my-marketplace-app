<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json([
            'status' => 'success',
            'message' => 'permissions list',
            'permissions' => $permissions,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
        $permission = Permission::create(['name' => $request->name]);
        return response()->json([
            'status' => 'success',
            'message' => 'permission created successfully',
            'permission' => $permission,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'permission info',
            'permission' => $permission,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$id,
        ]);
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);
        return response()->json([
            'status' => 'success',
            'message' => 'permission updated successfully',
            'permission' => $permission,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'permission deleted successfully',
        ], 200);
    }
}
