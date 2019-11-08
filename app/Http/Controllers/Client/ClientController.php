<?php

namespace App\Http\Controllers\Client;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ClientTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientController extends ApiController
{
    public function __construct()
    {
        // parent::__construct();
        // $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . ClientTransformer::class)->only(['store', 'update']);
    }

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
            'name' => 'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'surname' => 'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'bussiness_name' => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'description' => 'required',
            'logo' => 'required|mimes:jpg,jpeg,png,|max:3000'
        ];

        $fecha_actual = date("d") . "-" . date("m") . "-" . date("Y");

        $this->validate($request, $rules);

        $extension = $request->logo->extension();
        //$fields = $request->all();

        $data = $request->all();

        // print_r($data);
        // die();

        //$clientName = strtolower(str_replace(' ', '_', $data['bussiness_name']));
        $clientName = str_slug($data['bussiness_name'], '_');

        $nameFile = $clientName.'-'.$fecha_actual.'.'.$extension;

        $data['status'] = Client::ACTIVE;
        //$data['logo'] = $request->logo->store($clientName.'-'.$fecha_actual,'images'); Crea carpeta
        $data['logo'] = $request->logo->storeAs('', $nameFile, 'images');

        $client = Client::create($data);

        return $this->showOne($client, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $this->showOne($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $rules = [
            'bussiness_name' => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|unique:clients,bussiness_name,' . $client->id,
            'status' => 'in:' . Client::ACTIVE . ',' . Client::INACTIVE,
            'name' => 'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'surname' => 'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'description' => 'required',
            'logo' => 'required|mimes:jpg,jpeg,png,|max:3000'
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

            $fecha_actual = date("d") . "-" . date("m") . "-" . date("Y");
            $extension = $request->logo->extension();
            $clientName = str_slug($request->bussiness_name, '_');
            $nameFile = $clientName.'-'.$fecha_actual.'.'.$extension;

            // $clienteID = $client['id'];
            // $hasLogo = DB::table('clients')->where('id', $clienteID)->pluck('logo');

            $exists = is_file( 'img/'.$client->logo );

            // print_r($exists);
            // die();

            if ($exists) {
                unlink('img/'.$client->logo);
            }

            $client->logo = $request->logo->storeAs('', $nameFile, 'images');
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
    public function destroy(Client $client)
    {
        unlink('img/'.$client->logo); // Eliminamos de la ruta public/img/ el logo del cliente
        $client->delete();

        return $this->showOne($client);
    }
}
