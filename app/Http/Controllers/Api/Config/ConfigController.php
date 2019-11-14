<?php

namespace App\Http\Controllers\Api\Config;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Legal;

class ConfigController extends Controller
{
    public function getFields()
    {
        $data['genders'] = config('enums.genders');
        $data['occasions'] = config('enums.occasions');
        $data['relations'] = config('enums.relations');
        $data['categories'] = $this->getCategories();

        return $this->json(null, $data);
    }

    private function getCategories()
    {
        $categoryCollection = collect();
        foreach (Category::active()->get() as $category) {
            $categoryCollection->push([
                'name' => $category->name,
                'image' => ['src' => $category->image->src]
            ]);
        }

        return $categoryCollection;
    }
}