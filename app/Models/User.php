<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $cpf
 * @property \Illuminate\Support\Carbon|null $birth
 * @property string|null $gender
 * @property string $type
 * @property int|null $gym_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Gym[] $gyms
 * @property-read \App\Models\Gym|null $associatedGym
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'birth',
        'gender',
        'type',
        'gym_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function associatedGym(): BelongsTo
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }

    public function memberGyms(): BelongsToMany
    {
        return $this->belongsToMany(Gym::class, 'gym_user', 'user_id', 'gym_id');
    }

    public function getGymsAttribute(): Collection
    {
        if (in_array($this->type, ['manager', 'employee']) && $this->associatedGym) {
            return new Collection([$this->associatedGym]);
        }

        if ($this->type === 'member') {
            return $this->memberGyms()->get();
        }

        return new Collection();
    }

    public function hasActiveSubscriptionForGym($gymId)
    {
        return $this->subscriptions()
            ->whereHas('plan', function ($query) use ($gymId) {
                $query->where('gym_id', $gymId);
            })
            ->where('stripe_status', 'active')
            ->where('ends_at', '>=', Carbon::now())
            ->exists();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function gyms(): BelongsToMany
    {
        return $this->belongsToMany(Gym::class, 'gym_user', 'user_id', 'gym_id');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }
}