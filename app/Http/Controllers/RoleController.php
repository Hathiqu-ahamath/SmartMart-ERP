<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('roles.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'permissions' => 'array|exists:permissions,id',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $role = Role::create($validated);
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'permissions' => 'array|exists:permissions,id',
        ]);
        $role->update($validated);
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete role with assigned users.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
