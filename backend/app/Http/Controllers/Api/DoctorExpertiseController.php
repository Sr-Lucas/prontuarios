<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorExpertise;
use Illuminate\Http\Request;

class DoctorExpertiseController extends Controller
{
    private $expertise;

    function __construct(DoctorExpertise $expertise)
    {
        $this->expertise = $expertise;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expertises = $this->expertise->all();

        return response()->json($expertises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $expertise = $this->expertise->create($data);

        return response()->json($expertise);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expertise = $this->expertise->find($id);

        return response()->json($expertise);
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
        $expertise = $this->expertise->find($id);
        $expertise->update($data);

        return response()->json($expertise);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expertise = $this->expertise->find($id);
        $expertise->delete();

        return response()->json($expertise);
    }
}
