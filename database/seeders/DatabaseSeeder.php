<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder {
    public function run() {
        // Create Roles
        $adminRole = Role::create( [ 'name' => 'Creator' ] );

        // Create Permissions
        Permission::create( [ 'name' => 'manage users' ] );
        Permission::create( [ 'name' => 'manage roles' ] );
        Permission::create( [ 'name' => 'view dashboard' ] );

        // Assign Permissions to Roles
        $adminRole->givePermissionTo( [ 'manage users', 'manage roles', 'view dashboard' ] );

        // Create an Admin User
        $admin = User::create( [
            'name' => 'Chris W.',
            'email' => 'chris@thinbluelinerp.cc',
            'password' => bcrypt( 'Bypass.Home22.!!' )
        ] );

        $admin->assignRole( 'Creator' );
    }
}