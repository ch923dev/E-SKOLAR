<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function moduleName() : string
    {
        return Str::plural('User');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'contact_number',
        'avatar_url'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessFilament(): bool
    {
        return true;
        // return$this->hasVerifiedEmail();
    }
    public static function get_users(){
        return static::whereNot('role_id', Role::where('role', 'Scholar')->pluck('id', 'id'))
        ->whereNot('role_id', Role::where('role', 'Organization')->pluck('id', 'id'));
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return '/storage/'.$this->avatar_url;
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, PermissionRole::class, 'role_id', 'id', 'role_id', 'permission_id');
    }
    public function scholar(): HasOne
    {
        return $this->hasOne(Scholar::class);
    }
}
