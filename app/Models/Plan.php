<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'duration_unit',
        'type',
        'gym_id',
        'loyalty_months',
        'installment_options',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'installment_options' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get the gym that owns the plan.
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
