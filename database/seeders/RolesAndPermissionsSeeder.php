<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Config::get('roles');
        $permissions = Config::get('permissions');

        DB::transaction(function () use ($roles, $permissions) {
            $this->createPermissions();
            $this->createRolesAndAssignPermissions($roles, $permissions);
            $this->createAdminUser();
        });
    }


    /**
     * Create permissions for the given permission names.
     *
     * @param array $permissionNames
     * @return void
     */
    private function createPermissions(): void
    {
        $permissions = array_keys(Config::get('permissions'));

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
            ]);
        }
    }


    /**
     * Create roles and assign permissions based on the given configuration.
     *
     * @param array $roles
     * @param array $permissions
     * @return void
     */
    private function createRolesAndAssignPermissions(array $roles, array $permissions): void
    {
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $permissionModels = Permission::whereIn('name', $rolePermissions)->get();
            $role->permissions()->sync($permissionModels->pluck('id')->toArray());
        }
    }

    /**
     * Create the initial admin user account.
     *
     * @return void
     */
    private function createAdminUser(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'other_names' => 'Admin',
            'role' => 'admin',
            'nameSlug' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'phone' => '08132634481',
            'address' => 'No. 1 Str Road, City State, Country'
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->sync([$adminRole->id]);
    }
}
