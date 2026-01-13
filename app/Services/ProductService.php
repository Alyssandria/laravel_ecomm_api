<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService {

    public string $base;
    public string $searchUrl;

    public function __construct()
    {
        $this->base = config('products.base');
        $this->searchUrl = config('products.base') . '/search';
    }

    public function getMany(array $params) {
        $query = [
            'skip' => isset($params['skip']) ? $params['skip'] : null,
            'limit' => isset($params['limit']) ? $params['limit'] : null,
            'select' => isset($params['select']) ? $params['select'] : null,
            'sortBy' => isset($params['sortBy']) ? $params['sortBy'] : null,
            'order' => isset($params['order']) ? $params['order'] : null,
            'q' => isset($params['search']) ? $params['search'] : null,
        ];

        $url = "";
        if(isset($params['search'])){
            $url = $this->searchUrl;
        } else {
            $url = $this->base;
        }

        $response = Http::get($url, $query);

        if(!$response->ok()){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong, please try again later",
                'global' => true
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => "Products retrieved successfull",
            'data' => $response->json()

        ]);
    }
}
