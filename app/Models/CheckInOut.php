<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOut extends Model
{
    use HasFactory;

    protected $table = 'check_in_out';
    protected $fillable = [
        'gym_id',
        'user_id',
        'check_in',
        'check_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}