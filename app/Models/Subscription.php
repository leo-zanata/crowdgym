<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'user_id',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
