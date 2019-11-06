<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;
use Illuminate\Support\Facades\DB;

class ProductController extends ApiController
{
    public function __construct()
    {
        // parent::__construct();
        // $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
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
            'name' => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|unique:products',
            'description' => 'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'file_route' => 'required|mimes:zip|max:10000',
            'img' => 'required|mimes:jpg,jpeg,png,|max:3000',
            'client_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required'
        ];

        $fecha_actual = date("d") . "-" . date("m") . "-" . date("Y");

        $this->validate($request, $rules);

        $extension1 = $request->img->extension();

        $extension2 = $request->file_route->extension();

        $data = $request->all();

        $clienteID = $data['client_id'];

        $clientName = DB::table('clients')->where('id', $clienteID)->pluck('name'); // Obtener una columna

        // print_r($clientName[0]);
        // die();

        $productName = str_slug($data['name'], '_');

        $nameImg = $productName.'-'.$fecha_actual.'.'.$extension1;
        $nameFile = $productName.'-'.$fecha_actual.'.'.$extension2;

        $data['status'] = Product::ACTIVE;

        // $data['img'] = $request->img->store($clientName[0],  'product_file'); // Crea carpeta
        // $data['file_route'] = $request->file_route->store($clientName[0], 'product_file'); // Crea carpeta
        $data['img'] = $request->img->storeAs($clientName[0].'-'.$productName, $nameImg, 'product_file');
        $data['file_route'] = $request->file_route->storeAs($clientName[0].'-'.$productName, $nameFile, 'product_file');

        $product = Product::create($data);

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
            // unlink('product_file/'.$data['img']);
            // unlink('product_file/'.$data['file_route']);
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
