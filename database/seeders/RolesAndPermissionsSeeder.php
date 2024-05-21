<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            'admin',
            'application-manager',
            'department-manager',
            'exam-manager',
            'faculty-manager',
            'payment-manager',
            'site-settings-manager',
            'student-manager',
            'admin-manager',
            'scholarship-manager'
        ];

        // Define permissions for each role
        $adminPermissions = [
            'manage-applications', 'create-application', 'edit-application', 'delete-application', 'view-application',
            'manage-departments', 'create-department', 'edit-department', 'delete-department', 'view-department',
            'manage-exams', 'create-exam', 'edit-exam', 'delete-exam', 'view-exam',
            'manage-faculties', 'create-faculty', 'edit-faculty', 'delete-faculty', 'view-faculty',
            'manage-payments', 'create-payment', 'edit-payment', 'delete-payment', 'view-payment',
            'manage-payment-methods', 'create-payment-method', 'edit-payment-method', 'delete-payment-method', 'view-payment-method',
            'manage-site-settings', 'edit-site-settings', 'view-site-settings',
            'manage-students', 'create-student', 'edit-student', 'delete-student', 'view-student',
            'manage-admins', 'create-admin', 'edit-admin', 'delete-admin', 'view-admin',
            'manage-scholarship', 'create-scholarship', 'edit-scholarship', 'view-scholarship', 'delete-scholarship'
        ];

        // Create permissions
        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        foreach ($roles as $role) {
            $newRole = Role::firstOrCreate(['name' => $role]);

            if ($role === 'admin') {
                $this->assignPermissionsToRole($newRole, $adminPermissions);
            } else {
                $rolePermissions = $this->getRolePermissions($role);
                $this->assignPermissionsToRole($newRole, $rolePermissions);
            }
        }

        // Create the initial admin account
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

        // Assign 'admin' role to the main admin user
        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->sync([$adminRole->id]);
    }

    private function getRolePermissions($roleName)
    {
        // Define permissions for each role
        $rolePermissions = [
            'application-manager' => ['manage-applications', 'create-application', 'edit-application', 'delete-application', 'view-application'],
            'faculty-manager' => ['manage-faculties', 'create-faculty', 'edit-faculty', 'delete-faculty', 'view-faculty'],
            'department-manager' => ['manage-departments', 'create-department', 'edit-department', 'delete-department', 'view-department'],
            'payment-manager' => ['manage-payments', 'create-payment', 'edit-payment', 'delete-payment', 'view-payment', 'manage-payment-methods', 'create-payment-method', 'edit-payment-method', 'delete-payment-method', 'view-payment-method'],
            'site-settings-manager' => ['manage-site-settings', 'edit-site-settings', 'view-site-settings'],
            'student-manager' => ['manage-students', 'create-student', 'edit-student', 'delete-student', 'view-student'],
            'admin-manager' => ['manage-admins', 'create-admin', 'edit-admin', 'delete-admin', 'view-admin'],
            'exam-manager' => [
                'manage-exams', 'create-exam', 'edit-exam', 'delete-exam', 'view-exam',
            ],
            'scholarship-manager' => ['manage-scholarship', 'create-scholarship', 'edit-scholarship', 'view-scholarship', 'delete-scholarship']
        ];

        return $rolePermissions[$roleName] ?? [];
    }

    private function assignPermissionsToRole(Role $role, array $permissionNames): void
    {
        $permissions = Permission::whereIn('name', $permissionNames)->get();
        $role->permissions()->sync($permissions->pluck('id')->toArray());
    }
}
