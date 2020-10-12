<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private $doctor;

    function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = $this->doctor->with('user')->with('expertise')->get();

        return response()->json($doctors);
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
            'expertise_id' => 'bail|required',
            'crm' => 'bail|required',
          ]);

        $credentials = $request->validate([
            'cpf' => 'bail|required|cpf',
            'password' => 'bail|required|min:6',
        ]);

        $user = User::create([
            'cpf' => $credentials['cpf'],
            'password' => bcrypt($credentials['password']),
            'user_type' => 'doctor',
        ]);

        if(!$user) {
            return response()->json([
                'error' => 'An errour ocurred when inserting user.',
            ]);
        }

        $doctor = $this->doctor->create([
            'name' => $data['name'],
            'expertise_id' => $data['expertise_id'],
            'crm' => $data['crm'],
            'user_id' => $user['id'],
        ]);

        if (!$doctor) {
            $user->delete();
            return response()->json([
                'error' => 'An errour ocurred when inserting doctor.',
            ]);
        }

        return response()->json($doctor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = $this->doctor->find($id);

        return response()->json($doctor);
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
        $doctor = $this->doctor->find($id);
        $doctor->update($data);

        return response()->json($doctor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = $this->doctor->find($id);
        $doctor->delete();

        return response()->json($doctor);
    }
}
