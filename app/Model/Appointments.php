<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'date',
    ];

}
