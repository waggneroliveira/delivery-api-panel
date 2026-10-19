<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blog_categories')->upsert(
            [
                [
                    'id' => 1,
                    'title' => 'No bairro',
                    'slug'  => 'no-bairro',
                    'active' => 1,
                    'sorting' => 0,
                ]
            ],
            ['id'], // campo único
            ['title', 'slug', 'active', 'sorting'] // campos a atualizar caso exista
        );
    }
}
