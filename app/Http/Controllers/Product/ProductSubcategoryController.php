<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductSubcategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $subcategories = $product->subcategories;
        return $this->showOne($subcategories);
    }
}
