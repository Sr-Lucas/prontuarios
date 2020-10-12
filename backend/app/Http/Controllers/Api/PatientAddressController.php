<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientAddress;
use Illuminate\Http\Request;

class PatientAddressController extends Controller
{
    private $patientAddress;

    function __construct(PatientAddress $patientAddress)
    {
        $this->patientAddress = $patientAddress;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($patient_id)
    {
        $patientAddresses = $this->patientAddress
            ->with('patient')
            ->where('patient_id', '=', $patient_id)
            ->where('is_deleted', '<>', '0')
            ->get();

        return response()->json($patientAddresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $patient_id)
    {
        $data = $request->all();

        $patientAddress = $this->patientAddress->create([
            'cep' => $data['cep'],
            'city' => $data['city'],
            'state' => $data['state'],
            'street' => $data['street'],
            'neighborhood' => $data['neighborhood'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'reference' => $data['reference'],
            'patient_id' => $patient_id,
        ]);

        return response()->json($patientAddress);
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
        $patientAddress = $this->patientAddress->find($id);
        $patientAddress->update($data);

        return response()->json($patientAddress);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patientAddress = $this->patientAddress->find($id);
        $patientAddress->delete();

        return response()->json($patientAddress);
    }
}
