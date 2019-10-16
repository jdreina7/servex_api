<?php

namespace App\Http\Controllers\Role;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class RoleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        //return response()->json(['data' => $roles], 200);
        return $this->showAll($roles);
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
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();

        $role = Role::create($fields);

        return $this->showOne($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->showOne($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        $rules = [
            'status' => 'in:' . Role::ACTIVE . ',' . Role::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $role->name = $request->name;
        }

        if ($request->has('status')) {
            $role->status = $request->status;
        }

        if(!$role->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $role->save();

        return $this->showOne($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->showOne($role);
    }
}
