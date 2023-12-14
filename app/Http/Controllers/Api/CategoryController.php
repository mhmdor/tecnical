<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index(Request $request)
    {
        $categories = Category::all();

        return $this->apiResponse(['categories' =>  CategoryResource::collection($categories),], self::STATUS_OK, 'get Categories successfully');
    }
}
