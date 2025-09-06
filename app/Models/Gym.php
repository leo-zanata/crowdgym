<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function manager(): HasOne
    {
        return $this->hasOne(User::class, 'gym_id')->where('type', 'manager');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'gym_user', 'gym_id', 'user_id')->where('type', 'member');
    }
}