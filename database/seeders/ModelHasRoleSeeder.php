<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModelHasRoleSeeder extends Seeder
{

    public function run(): void
    {
        User::find(1)->assignRole('Super');
    }
}
