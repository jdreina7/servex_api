<?php

namespace App\Http\Controllers\Client;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ClientProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        $products = $client->products;
        return $this->showAll($products);
    }

    
}
