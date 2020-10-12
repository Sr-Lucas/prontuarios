<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AttendanceRequestController extends Controller
{
    private $attendanceRequest;

    function __construct(AttendanceRequest $attendanceRequest)
    {
        $this->attendanceRequest = $attendanceRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::getPayload($token)->toArray();

        if($payload['user_type'] == 'administrator') {
            $attendanceRequests = $this->attendanceRequest->get();
            return response()->json($attendanceRequests);
        }

        $user = User::with($payload['user_type'])->find($payload['user_id']);

        $attendanceRequests = $this->attendanceRequest
                                    ->with('doctor')
                                    ->with('patient')
                                    ->where(
                                        [
                                            $payload['user_type'].'_id' =>
                                            $user[$payload['user_type']]->id
                                        ]
                                    )
                                    ->orderBy('status', 'ASC')
                                    ->get();

        return response()->json($attendanceRequests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $doctor_id)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::getPayload($token)->toArray();

        if($payload['user_type'] != 'patient') {
            return response()->json([
                "error" => "Only patients can acesses this route!"
            ]);
        }

        $user = User::with('patient')->find($payload['user_id']);

        /**
         * Checks if the current patient has an attendance request with status pending
         * and if yes it blocks the creation this request.
         */
        $existsAttendanceRequestsPendingForPatient = AttendanceRequest::with('patient')
        ->where('patient_id', '=', $user->patient->id)
        ->whereNull('status')
        ->get();

        if(count($existsAttendanceRequestsPendingForPatient)) {
            return response()->json([
                'error' => 'This patient aready have an attendance request pending!',
                'message' => 'Você já possui uma requisição de atendimento pendente. Aguarde ser aceita ou rejeitada para realizar uma nova!'
            ], 200);
        }


        /**
         * Checks if the current Doctor has already a request pending and if yes
         * it blocks the creation of this request
         */
        $existsAttendanceRequestsPendingForDoctor = AttendanceRequest::with('patient')
        ->where('doctor_id', '=', $doctor_id)
        ->whereNull('status')
        ->get();

        if(count($existsAttendanceRequestsPendingForDoctor)) {
            return response()->json([
                'error' => 'This doctor aready have an attendance request pending!',
                'message' => 'O doutor possui uma requisição de atendimento pendente. Aguarde ou solitite para outro doutor!',
            ], 200);
        }



        $attendanceRequest = $this->attendanceRequest->create([
            'patient_id' => $user['patient']->id,
            'doctor_id' => $doctor_id,
        ]);

        return response()->json($attendanceRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendanceRequest = $this->attendanceRequest->with('patient')
                                                    ->with('doctor')
                                                    ->find($id);

        return response()->json($attendanceRequest);
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
        $request->validate([
            'status' => 'bail|required|boolean',
        ]);

        $status = $request[ 'status' ];

        $attendanceRequest = $this->attendanceRequest->find($id);
        $attendanceRequest->update([
            'status' => $status,
        ]);

        return response()->json($attendanceRequest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendanceRequest = $this->attendanceRequest->find($id);
        $attendanceRequest->delete();

        return response()->json($attendanceRequest);
    }
}
