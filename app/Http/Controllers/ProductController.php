<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductQueryRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index(ProductQueryRequest $request, ProductService $products) {
        return $products->getMany($request->validated());


    }
}
