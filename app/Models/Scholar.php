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


    protected $fillable = ['user_id','status','baranggay_id','scholarship_program_id','program_id','fname','lname'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function baranggay(): BelongsTo
    {
        return $this->belongsTo(Baranggay::class);
    }
    public function scholarship_program(): BelongsTo
    {
        return $this->belongsTo(ScholarshipProgram::class);
    }
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
    public function college(){
        return $this->hasOneThrough(College::class,Program::class,'id','id','program_id','college_id');
    }
}
