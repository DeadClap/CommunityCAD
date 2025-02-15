<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller {
    public function dashboard() {
        return Inertia::render( 'Admin/Dashboard' );
    }

    public function users() {
        return Inertia::render( 'Admin/Users', [
            'users' => User::with( 'roles' )->get()
        ] );
    }

    public function roles() {
        return Inertia::render( 'Admin/Roles', [
            'roles' => Role::all()
        ] );
    }
}