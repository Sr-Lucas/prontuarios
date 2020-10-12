<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\ExamResult;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function show($filename)
    {

        $file =  '/var/www/storage/app/public/exam_files/'.$filename;
        $headers = [
            'Content-Type',
            'application/pdf'
        ];

        return response()->download($file, $filename, $headers);
    }
}
