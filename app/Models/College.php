<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Rennokki\QueryCache\Traits\QueryCacheable;

class College extends Model
{
    use HasFactory,QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['colleges'];
    public $cachePrefix = 'colleges_';

    public $cacheDriver = 'file';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','abbre'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function programs() : HasMany{
        return $this->hasMany(Program::class);
    }
    public function scholars() : HasManyThrough{
        return $this->hasManyThrough(Scholar::class,Program::class);
    }
}
