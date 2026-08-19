<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The authentication guard used by Spatie Permission.
     */
    protected string $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'status',
        'is_super_admin',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'is_super_admin'    => 'boolean',
            'deleted_at'        => 'datetime',
        ];
    }

    /**
     * Determine whether the user is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Determine whether the user is Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin || $this->hasRole('Super Admin');
    }

    /**
     * JWT Identifier.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT Custom Claims.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    public static function getAll()
    {
        return self::with('role')->orderBy('full_name')->get();
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tenant()
    {
        return $this->hasOne(
            Tenant::class,
            'user_id'
        );
    }

    public function fitoutContractor()
    {
        return $this->hasOne(
            FitoutContractor::class,
            'user_id'
        );
    }
}