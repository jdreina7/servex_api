<?php

namespace App\Http\Controllers\Client;

use App\Client;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class ClientSubcategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        echo $client;
    }

}
