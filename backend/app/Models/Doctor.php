<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'crm',
        'expertise_id',
        'user_id',
    ];

    public function expertise()
    {
        return $this->belongsTo(DoctorExpertise::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
