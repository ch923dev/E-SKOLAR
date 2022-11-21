<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;

class Role extends Model
{
    use HasFactory;


    public static function moduleName() : string
    {
        return Str::plural('Role');
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role'];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function modules()
    {
        return $this->belongsToMany(Module::class)->withPivot('level');
    }
}
