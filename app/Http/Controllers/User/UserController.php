<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    public function __construct()
    {
        // parent::__construct();
        // $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api');
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        //return response()->json(['data' => $users], 200);
        return $this->showAll($users);
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
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = bcrypt($request->password);

        $user = User::create($fields);

        //return response()->json(['data' => $user], 201);
        return $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //$user = User::findOrFail($id);
        //return response()->json(['data' => $user], 200);
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //$user = User::findOrFail($id);

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6',
            'status' => 'in:' . User::ACTIVE . ',' . User::INACTIVE,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('surname')) {
            $user->surname = $request->surname;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('image')) {
            $user->image = $request->image;
        }

        if ($request->has('status')) {
            $user->status = $request->status;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('Se debe realizar al menos un cambio para actualizar', 422);
        }

        $user->save();

        //return response()->json(['data' => $user], 200);
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //$user = User::findOrFail($id);

        $user->delete();

        //return response()->json(['data' => $user], 200);
        return $this->showOne($user);
    }
}
