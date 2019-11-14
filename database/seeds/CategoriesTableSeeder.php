<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<2; $i++) {
            $category = factory(\App\Models\Category::class)->create();
            factory(\App\Models\Media::class)->create([
                'mediable_id' => $category->id,
                'mediable_type' => 'App\Models\Category',
                'type' => 'image'
            ]);
        }
    }
}
