<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleController extends Controller
{
    /**
     * Initialize controller with middleware assignments.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    /**
     * Displays a paginated list of roles along with their associated permissions.
     *
     * @return View The view displaying the roles index with the retrieved roles and permissions data.
     */
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::with('permissions')->orderBy('id', 'DESC')->paginate(3)
        ]);
    }

    /**
     * Displays the form for creating a new role.
     *
     * @return View Renders the role creation view with a list of permissions.
     */
    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Handles the storage of a new role along with its associated permissions.
     *
     * @param StoreRoleRequest $request The request object containing the role data and permissions.
     * @return RedirectResponse Redirects to the roles index page with a success message.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('New role is added successfully.');
    }

    /**
     * Redirects to the roles index page.
     *
     * @return RedirectResponse Redirects users to the roles index page.
     */
    public function show(): RedirectResponse
    {
        return redirect()->route('roles.index');
    }

    /**
     * Displays the edit form for a given role while restricting edits to the "Super Admin" role.
     *
     * @param Role $role The role entity to be edited.
     * @return View The view displaying the role edit form along with associated permissions.
     *
     * @throws HttpException If the "Super Admin" role is attempted to be edited.
     */
    public function edit(Role $role): View
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Updates an existing role with new data and synchronizes its associated permissions.
     *
     * @param UpdateRoleRequest $request The request object containing the updated role data and permissions.
     * @param Role $role The role instance to be updated.
     * @return RedirectResponse Redirects back with a success message indicating the role has been updated.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->back()
                ->withSuccess('Role is updated successfully.');
    }

    /**
     * Handles the deletion of a specified role while ensuring certain conditions are met.
     *
     * @param Role $role The role instance to be deleted.
     * @return RedirectResponse Redirects to the roles index page with a success message upon successful deletion.
     * @throws HttpException Thrown if the role is 'Super Admin' or
     *         if the authenticated user is assigned the role being deleted.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
                ->withSuccess('Role is deleted successfully.');
    }
}
