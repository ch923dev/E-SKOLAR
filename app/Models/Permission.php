<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
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
    protected $fillable = ['name'];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function users(){
        return $this->hasManyThrough(User::class,PermissionRole::class,'permission_id','role_id','id','role_id');

    }
}
