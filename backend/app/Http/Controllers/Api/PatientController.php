<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patient;

    function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = $this->patient
                        ->with('addresses')
                        ->with('user')
                        ->where('is_deleted', '=', '0')
                        ->get();

        return response()->json($patients);
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
          'phone' => 'bail|required'
        ]);

        $credentials = $request->validate([
            'cpf' => 'bail|required|cpf',
            'password' => 'bail|required|min:6',
        ]);

        $user = User::create([
            'cpf' => $credentials['cpf'],
            'password' => bcrypt($credentials['password']),
            'user_type' => 'patient'
        ]);

        if (!$user) {
            return response()->json([
                'error' => 'An errour ocurred when inserting user.',
            ]);
        }

        $patient = $this->patient->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'user_id' => $user['id'],
        ]);

        if (!$patient) {
            $user->delete();
            return response()->json([
                'error' => 'An errour ocurred when inserting patient.',
            ]);
        }

        return response()->json($patient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = $this->patient->with('addresses')->with('user')->find($id);

        return response()->json($patient);
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
        $patient = $this->patient->find($id);
        $patient->update($data);

        return response()->json($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = $this->patient->find($id);
        $patient->user;
        $patient->addresses;

        $patient->addresses[0]->update([
            'is_deleted' => 1,
            'cep' => '',
            'number' => '',
            'complement' => '',
        ]);

        $patient->user->update([
            'is_deleted' => 1,
            'cpf' => '',
        ]);

        $patient->update([
            'is_deleted' => 1,
            'phone' => '',
        ]);

        return response()->json($patient);
    }
}
