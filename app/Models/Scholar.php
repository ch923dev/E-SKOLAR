<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scholar extends Model
{
    use HasFactory;
    protected $fillable = ['id','fname', 'mname', 'lname', 'program_id', 'sponsor_id', 'last_allowance_receive', 'year_id','scholar_status_id','user_id'];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function scholar_status(): BelongsTo
    {
        return $this->belongsTo(ScholarStatus::class);
    }
    public function allowance_receive(): BelongsTo
    {
        return $this->belongsTo(Academic::class,'last_allowance_receive','id');
    }
    public function college(){
        return $this->hasOneThrough(College::class,Program::class,'id','id','program_id','college_id');
    }
}
