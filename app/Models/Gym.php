<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    protected $table = 'gyms';
    protected $fillable = [
        'gym_name',
        'manager_name',
        'gym_phone',
        'manager_phone',
        'manager_email',
        'manager_cpf',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
        'opening',
        'closing',
        'week_day',
        'status',
    ];
}