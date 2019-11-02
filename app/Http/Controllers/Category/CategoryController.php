<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    public function __construct()
    {
        // parent::__construct(); 
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except([ 'store', 'update', 'destroy']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        //return response()->json(['data' => $categories], 200);
        return $this->showAll($categories);
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
            'name' => 'required|unique:categories',
            'img' => 'required'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();

        $category = Category::create($fields);

        return $this->showOne($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'unique:categories,name,' . $category->id,
            'status' => 'in:' . Category::ACTIVE . ',' . Category::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $category->name = $request->name;
        }

        if ($request->has('description')) {
            $category->description = $request->description;
        }

        if ($request->has('img')) {
            $category->img = $request->img;
        }

        if ($request->has('status')) {
            $category->status = $request->status;
        }

        if(!$category->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $category->save();

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category);
    }
}
