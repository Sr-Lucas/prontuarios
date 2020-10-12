<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\ExamResult;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamResultController extends Controller
{
    private $examResult;

    public function __construct(ExamResult $examResult)
    {
        $this->examResult = $examResult;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attendance_request_id)
    {
        $examResults = $this->examResult->with('file')
                                        ->with('attendance_request')
                                        ->where(
                                            'attendance_request_id',
                                            '=',
                                            $attendance_request_id
                                        )->get();

        return response()->json($examResults);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $attendance_request_id)
    {
        $attendance_request = AttendanceRequest::find($attendance_request_id);

        if (!$attendance_request) {
            return response()->json([
                'error' => 'Attendance request not found!',
            ]);
        }

        $file = $request->file('file');
        $file->store('exam_files');

        $fileStored = File::create([
            'filename' => $file->hashName(),
        ]);

        if (!$fileStored) {
            return response()->json([
                'error' => 'Error while inserting file informations in database',
            ]);
        }

        $exam_result = ExamResult::create([
            'attendance_request_id' => $attendance_request->id,
            'file_id' => $fileStored->id,
        ]);

        return response()->json([
            'exam_result' => $exam_result,
            'file' => $fileStored
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $examResult = $this->examResult->find($id);

        if (!$examResult) {
            return response()->json([
                'error' => 'Exam result not found',
            ]);
        }

        $filename = $examResult->file->filename;

        Storage::disk('public')->delete(['/exam_files/'.$filename]);

        $examResult->delete();

        return response()->json($examResult);
    }
}
