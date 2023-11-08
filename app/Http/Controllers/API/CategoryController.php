<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CategoryResource;

class CategoryController extends BaseController
{
    public function index(): JsonResponse
    {
        $categories = Category::isActive()->get(['id', 'name']);
        return $this->sendResponse(CategoryResource::collection($categories), 'Categories fetched.');
    }

    public function store(): JsonResponse {

    }
}
