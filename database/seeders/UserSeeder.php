<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * List of permissions to add.
     */
    private $permissions = [
                            'view_data_agama',
                            'create_data_agama',
                            'edit_data_agama',
                            'delete_data_agama',
                            'trash_data_agama',
                            'view_data_akseptor_kb',
                            'create_data_akseptor_kb',
                            'edit_data_akseptor_kb',
                            'delete_data_akseptor_kb',
                            'trash_data_akseptor_kb',
                            'view_data_asuransi',
                            'create_data_asuransi',
                            'edit_data_asuransi',
                            'delete_data_asuransi',
                            'trash_data_asuransi',
                            'view_data_bahasa',
                            'create_data_bahasa',
                            'edit_data_bahasa',
                            'delete_data_bahasa',
                            'trash_data_bahasa',
                            'view_data_cacat',
                            'create_data_cacat',
                            'edit_data_cacat',
                            'delete_data_cacat',
                            'trash_data_cacat',
                            'view_data_golongan_darah',
                            'create_data_golongan_darah',
                            'edit_data_golongan_darah',
                            'delete_data_golongan_darah',
                            'trash_data_golongan_darah',
                            'view_data_hubungan_keluarga',
                            'create_data_hubungan_keluarga',
                            'edit_data_hubungan_keluarga',
                            'delete_data_hubungan_keluarga',
                            'trash_data_hubungan_keluarga',
                            'view_data_jabatan',
                            'create_data_jabatan',
                            'edit_data_jabatan',
                            'delete_data_jabatan',
                            'trash_data_jabatan',
                            'view_data_jenis_persalinan',
                            'create_data_jenis_persalinan',
                            'edit_data_jenis_persalinan',
                            'delete_data_jenis_persalinan',
                            'trash_data_jenis_persalinan',
                            'view_data_kawin',
                            'create_data_kawin',
                            'edit_data_kawin',
                            'delete_data_kawin',
                            'trash_data_kawin',
                            'view_data_kursus',
                            'create_data_kursus',
                            'edit_data_kursus',
                            'delete_data_kursus',
                            'trash_data_kursus',
                            'view_data_pekerjaan',
                            'create_data_pekerjaan',
                            'edit_data_pekerjaan',
                            'delete_data_pekerjaan',
                            'trash_data_pekerjaan',
                            'view_data_pendidikan',
                            'create_data_pendidikan',
                            'edit_data_pendidikan',
                            'delete_data_pendidikan',
                            'trash_data_pendidikan',
                            'view_data_penolong_kelahiran',
                            'create_data_penolong_kelahiran',
                            'edit_data_penolong_kelahiran',
                            'delete_data_penolong_kelahiran',
                            'trash_data_penolong_kelahiran',
                            'view_data_sakit_menahun',
                            'create_data_sakit_menahun',
                            'edit_data_sakit_menahun',
                            'delete_data_sakit_menahun',
                            'trash_data_sakit_menahun',
                            'view_data_status_dasar',
                            'create_data_status_dasar',
                            'edit_data_status_dasar',
                            'delete_data_status_dasar',
                            'trash_data_status_dasar',
                            'view_data_suku',
                            'create_data_suku',
                            'edit_data_suku',
                            'delete_data_suku',
                            'trash_data_suku',
                            'view_data_tempat_dilahirkan',
                            'create_data_tempat_dilahirkan',
                            'edit_data_tempat_dilahirkan',
                            'delete_data_tempat_dilahirkan',
                            'trash_data_tempat_dilahirkan',
                            'view_data_warganegara',
                            'create_data_warganegara',
                            'edit_data_warganegara',
                            'delete_data_warganegara',
                            'trash_data_warganegara',
                            'view_kelahiran',
                            'create_kelahiran',
                            'edit_kelahiran',
                            'delete_kelahiran',
                            'trash_kelahiran',
                            'view_keuangan',
                            'create_keuangan',
                            'edit_keuangan',
                            'delete_keuangan',
                            'trash_keuangan',
                            'view_penduduk',
                            'create_penduduk',
                            'edit_penduduk',
                            'delete_penduduk',
                            'trash_penduduk',
                            'view_perangkat',
                            'create_perangkat',
                            'edit_perangkat',
                            'delete_perangkat',
                            'trash_perangkat',
                            'view_users',
                            'create_users',
                            'edit_users',
                            'delete_users',
                            'trash_users',
                            'view_roles',
                            'create_roles',
                            'edit_roles',
                            'delete_roles',
                            'view_permissions',
                            'create_permissions',
                            'edit_permissions',
                            'delete_permissions',
                        ];

    /**
     * Seed the permission-role to database.
     */
    public function run(): void
    {
        $permissionOperator = [];
        $permissionUser = [];

        // Loop through each permission and create a new Permission record
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);

            // 'dele' refers to 'delete'. Operator can access all permissions except delete actions.
            if (substr($permission,0,5) != 'trash') {
                $permissionOperator[] = $permission;
            }

            // User only have permission to view
            if (substr($permission,0,4) == 'view') {
                $permissionUser[] = $permission;
            }
        }

        $permissionAdmin = Permission::pluck('id', 'id')->all();

        // Create admin User and assign the role to him.
        $admin = Role::create(['name' => 'Administrator']);
        $admin->syncPermissions($permissionAdmin);

        $userAdmin = User::create([
            'name'      => 'Budi Prastyo',
            'username'  => 'admin',
            'email'     => 'admin@email.com',
            'password'  => Hash::make('password'),
            'bio' => fake()->unique()->words(2, true), // Generate 2 unique words,
        ]);
        $userAdmin->assignRole($admin);

        // Create Operator User and assign the role to him.
        $operator = Role::create(['name' => 'Operator']);
        $operator->syncPermissions($permissionOperator);

        $userOperator = User::create([
            'name'      => 'Fisna Lestari',
            'username'  => 'operator',
            'email'     => 'operator@email.com',
            'password'  => Hash::make('password'),
            'bio' => fake()->unique()->words(2, true), // Generate 2 unique words,
        ]);
        $userOperator->assignRole($operator);

        // Create User User and assign the role to him.
        $user = Role::create(['name' => 'User']);
        $user->syncPermissions($permissionUser);

        User::factory()->count(5)->create()->each(function ($user) {
            $user->assignRole('User');
        });
    }
}