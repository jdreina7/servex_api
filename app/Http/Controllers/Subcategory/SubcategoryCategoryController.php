<?php

namespace App\Http\Controllers\Subcategory;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SubcategoryCategoryController extends ApiController
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
        $category = $subcategory->category;
        return $this->showOne($category);
    }

}
