<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{

    private $administrator;

    function __construct(Administrator $administrator)
    {
        $this->administrator = $administrator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrators = $this->administrator->with('user')->get();

        return response()->json($administrators);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'bail|required|string',
        ]);

        $credentials = $request->validate([
            'cpf' => 'bail|required|cpf',
            'password' => 'bail|required|min:6',
        ]);

        $user = User::create([
            'cpf' => $credentials['cpf'],
            'password' => bcrypt($credentials['password']),
            'user_type' => 'administrator',
        ]);

        if (!$user) {
            return response()->json([
                'error' => 'An errour ocurred when inserting user.',
            ]);
        }

        $administrator = $this->administrator->create([
            'name' => $data['name'],
            'user_id' => $user['id'],
        ]);

        if (!$administrator) {
            $user->delete();
            return response()->json([
                'error' => 'An errour ocurred when inserting administrator.',
            ]);
        }

        return response()->json($administrator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $administrator = $this->administrator->with('user')->find($id);

        return response()->json($administrator);
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
        $data = $request->all();
        $administrator = $this->administrator->with('user')->find($id);
        $administrator->update($data);

        return response()->json($administrator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $administrator = $this->administrator->with('user')->find($id);
        $administrator->delete();

        return response()->json($administrator);
    }
}
