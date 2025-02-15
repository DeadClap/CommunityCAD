<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class RoleController extends Controller {
    public function index() {
        return Inertia::render( 'Admin/Roles', [
            'roles' => Role::with( 'permissions' )->get(),
            'permissions' => Permission::all()
        ] );
    }

    public function store( Request $request ) {
        $role = Role::create( [ 'name' => $request->name ] );
        return redirect()->back()->with( 'success', 'Role Created' );
    }

    public function updatePermissions( Request $request, Role $role ) {
        $role->syncPermissions( $request->permissions );
        return redirect()->back()->with( 'success', 'Permissions Updated' );
    }

    public function destroy( Role $role ) {
        // ✅ Remove all associated permissions first
        $role->syncPermissions( [] );

        // ✅ Delete the role
        $role->delete();

        return redirect()->back()->with( 'success', 'Role Deleted' );
    }
}