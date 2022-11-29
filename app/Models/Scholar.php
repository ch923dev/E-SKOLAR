<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scholar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','status','baranggay_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function baranggay(): BelongsTo
    {
        return $this->belongsTo(Baranggay::class);
    }
}
