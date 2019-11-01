<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;

class ProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        //return response()->json(['data' => $products], 200);
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:products',
            'file_route' => 'required',
            'img' => 'required',
            'client_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();

        $product = Product::create($fields);

        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'unique:products,name,' . $product->id,
            'status' => 'in:' . Product::ACTIVE . ',' . Product::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $product->name = $request->name;
        }

        if ($request->has('description')) {
            $product->description = $request->description;
        }

        if ($request->has('file_route')) {
            $product->file_route = $request->file_route;
        }

        if ($request->has('img')) {
            $product->img = $request->img;
        }

        if ($request->has('status')) {
            $product->status = $request->status;
        }

        if ($request->has('client_id')) {
            $product->client_id = $request->client_id;
        }

        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }

        if ($request->has('subcategory_id')) {
            $product->subcategory_id = $request->subcategory_id;
        }

        if(!$product->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->showOne($product);
    }
}
