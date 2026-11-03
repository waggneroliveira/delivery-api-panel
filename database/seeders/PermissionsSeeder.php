<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $modules = config('module_permissions');

        foreach ($modules as $module => $config) {

            foreach ($config['actions'] as $action) {

                Permission::firstOrCreate([
                    'name' => strtolower(
                        "{$config['permission']}.{$action}"
                    ),
                ]);

            }
        }
    }
}
