<?php

namespace App\Http\Controllers\Client;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ClientController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        //return response()->json(['data' => $clients], 200);
        return $this->showAll($clients);
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
            'bussiness_name' => 'required',
            'description' => 'required',
            'logo' => 'required'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();

        $client = Client::create($fields);

        return $this->showOne($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return $this->showOne($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $rules = [
            'bussiness_name' => 'unique:clients,bussiness_name,' . $client->id,
            'status' => 'in:' . Client::ACTIVE . ',' . Client::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $client->name = $request->name;
        }

        if ($request->has('surname')) {
            $client->surname = $request->surname;
        }

        if ($request->has('email')) {
            $client->email = $request->email;
        }

        if ($request->has('bussiness_name')) {
            $client->bussiness_name = $request->bussiness_name;
        }

        if ($request->has('description')) {
            $client->description = $request->description;
        }

        if ($request->has('logo')) {
            $client->logo = $request->logo;
        }

        if ($request->has('status')) {
            $client->status = $request->status;
        }

        if(!$client->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $client->save();

        return $this->showOne($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return $this->showOne($client);
    }
}
