<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Academic extends Model
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
    protected $fillable = ['year', 'semester'];

    protected function academicYearSem(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $ends = $attributes['semester'] == 1 ? 'st' : 'nd' ;
                return $attributes['year'] . ' - ' . $attributes['semester']. $ends . ' Sem';
            }
        );
    }
}
