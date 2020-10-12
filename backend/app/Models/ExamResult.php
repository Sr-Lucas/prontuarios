<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_request_id',
        'file_id'
    ];

    public function attendance_request()
    {
        return $this->belongsTo(AttendanceRequest::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
