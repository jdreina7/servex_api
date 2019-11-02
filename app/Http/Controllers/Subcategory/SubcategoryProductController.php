<?php

namespace App\Http\Controllers\Subcategory;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SubcategoryProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Subcategory $subcategory)
    {
        $products = $subcategory->products;
        return $this->showAll($products);
    }

}
