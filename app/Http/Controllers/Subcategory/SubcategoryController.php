<?php

namespace App\Http\Controllers\Subcategory;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SubcategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        //return response()->json(['data' => $subcategories], 200);
        return $this->showAll($subcategories);
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
            'name' => 'required|unique:subcategories',
            'img' => 'required',
            'category_id' => 'required'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();

        $subcategory = Subcategory::create($fields);

        return $this->showOne($subcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        // $subcategory = Subcategories::findOrFail($id);
        return $this->showOne($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        // $subcategory = Subcategories::findOrFail($id);

        $rules = [
            'name' => 'unique:subcategories,name,' . $subcategory->id,
            'status' => 'in:' . Subcategory::ACTIVE . ',' . Subcategory::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $subcategory->name = $request->name;
        }

        if ($request->has('description')) {
            $subcategory->description = $request->description;
        }

        if ($request->has('img')) {
            $subcategory->img = $request->img;
        }

        if ($request->has('status')) {
            $subcategory->status = $request->status;
        }

        if ($request->has('category_id')) {
            $subcategory->category_id = $request->category_id;
        }

        if(!$subcategory->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $subcategory->save();

        return $this->showOne($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        // $subcategory = Subcategories::findOrFail($id);

        $subcategory->delete();

        return $this->showOne($subcategory);
    }
}
