<?php

namespace App\Http\Controllers\Internal\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Internal\Department\StoreDepartmentUserRequest;
use App\Http\Requests\Internal\Department\UpdateDepartmentUserRequest;
use App\Models\Internal\Department\DepartmentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DepartmentUserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        $users = DepartmentUser::paginate(5);

        return view('admin.internal.department.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $roles = Role::where('guard_name', 'dept_user')->get();

        return view('admin.internal.department.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentUserRequest $request): RedirectResponse {
        $data = $request->validated();

        $user = DepartmentUser::create($data);
        $user->assignRole($data['role']);

        return to_route('admin.internal.dept.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentUser $departmentUser): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentUser $departmentUser): void {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentUserRequest $request, DepartmentUser $departmentUser): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentUser $departmentUser): void {
        //
    }
}
