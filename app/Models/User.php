<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public static function findByFilters(array $data, $paginate = true, $limit = 10, $first = false)
    {
        $query = self::query();

        $query->when(!empty($data['id']), function ($q) use ($data) {
            $q->where('id', $data['id']);
        })
        ->when(!empty($data['name']), function ($q) use ($data) {
            $q->whereLike('name', $data['name']);
        })
        ->when(!empty($data['email']), function ($q) use ($data) {
            $q->where('email', $data['email']);
        });

        if ($first) {
            $filtered_data = $query->first();
        } elseif ($paginate) {
            $filtered_data = $query->paginate($limit);
        } else {
            $filtered_data = $query->get();
        }


        return $filtered_data;
    }
}
