<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ScholarshipOrganization extends Model
{
    use HasFactory;

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

    public function scholarship_programs() : BelongsToMany {
        return $this->belongsToMany(ScholarshipProgram::class);
    }
    public function scholars(): HasManyThrough
    {
        return $this->hasManyThrough(Scholar::class,ScholarshipOrganizationScholarshipProgram::class,'scholarship_organization_id','scholarship_program_id','id','scholarship_program_id');
    }
}
