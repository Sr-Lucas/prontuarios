<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'city',
        'state',
        'street',
        'neighborhood',
        'number',
        'complement',
        'reference',
        'patient_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
