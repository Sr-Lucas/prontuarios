<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'user_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted',
    ];

    public function addresses()
    {
        return $this->hasMany(PatientAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance_requests() {
        return $this->hasMany(AttendanceRequest::class);
    }
}
