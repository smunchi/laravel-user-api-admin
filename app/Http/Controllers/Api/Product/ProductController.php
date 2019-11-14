<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\Amazon\Amazon;

class ProductController extends Controller
{
    public function index()
    {
        $credentials['associate_tag'] = config('services.amazon.associate_tag');
        $credentials['key_id'] = config('services.amazon.key');
        $credentials['secret_key'] = config('services.amazon.secret');
        $credentials['response_group'] = 'offers,images';
        $credentials['category'] = 'books';
        $credentials['timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
        $credentials['provider'] = 'amazon';
        $credentials['service'] = 'AWSECommerceService';
        $credentials['operation'] = 'ItemSearch';

        $productApi = new Amazon($credentials);
        $productApi->setIsDummy(true);
        $response = $productApi->getProducts();

        return $this->json('Products information', $response);
    }
}