<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Warta', 'slug' => 'warta'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
        ];

        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
