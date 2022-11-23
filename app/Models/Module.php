<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Module extends Model
{
    use HasFactory;


    public static function moduleName() : string
    {
        return Str::plural('Module');
    }

    public static function manage($level, $model = null): bool
    {
        return ($model ? ($model->default ? false : $level == 2) : $level == 2);
    }
    public static function view($level, $model = null)
    {
        return ($model ? ($model->default ? $level == 2 : $level == 1 || $level == 2) : $level == 1 || $level == 2);
    }
    public static function level($user, $class)
    {
        return $user->role->modules->where('module', $class::moduleName())->first()->pivot->level;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('level');
    }
    public function roles_manage()
    {
        return $this->belongsToMany(Role::class)->wherePivot('level', 2);
    }
    public function roles_view()
    {
        return $this->belongsToMany(Role::class)->wherePivot('level', 1);
    }
    public function roles_not()
    {
        return $this->belongsToMany(Role::class)->wherePivot('level', 1);
    }
}
