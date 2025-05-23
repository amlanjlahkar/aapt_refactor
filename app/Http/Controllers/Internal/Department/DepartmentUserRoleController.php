<?php

namespace App\Http\Controllers\Internal\Department;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DepartmentUserRoleController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        $roles = Role::with('permissions')->paginate(5);

        return view('admin.internal.department.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $permissions = Permission::where('guard_name', 'dept_user')->get();

        return view('admin.internal.department.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = Validator::make($request->all(), [
            'role' => 'required|string',
            'permissions' => 'required|array',
        ])->validate();

        $role = Role::firstOrCreate(['name' => $validated['role'], 'guard_name' => 'dept_user']);
        $role->syncPermissions($validated['permissions']);

        return to_route('admin.internal.dept.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void {
        //
    }
}
