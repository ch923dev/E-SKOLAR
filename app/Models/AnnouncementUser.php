<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AnnouncementUser extends Pivot
{
    protected $fillable = ['announcement_id', 'user_id'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
