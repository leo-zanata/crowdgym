<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function operatingHours(): HasMany
    {
        return $this->hasMany(OperatingHour::class)->orderBy('day_of_week');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}