<?php

namespace App\Http\Controllers\Client;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ClientCategoryController extends ApiController
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
    public function index(Client $client)
    {
        $categories = $client->categories;
        return $this->showAll($categories);
    }

}
