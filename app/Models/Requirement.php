<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Requirement extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'filetypes' => 'array',
    ];
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
    protected $fillable = ['description','filetypes','announcement_id'];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['status','document']);
    }
}
