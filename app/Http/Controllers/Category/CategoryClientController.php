<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryClientController extends ApiController
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
    public function index(Category $category)
    {
        $clients = $category->clients;
        return $this->showAll($clients);
    }

}
