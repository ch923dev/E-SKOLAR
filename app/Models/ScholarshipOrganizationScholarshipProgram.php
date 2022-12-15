<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ScholarshipOrganizationScholarshipProgram extends Pivot
{
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
    protected $fillable = ['scholarship_program_id','scholarship_organization_id'];
}
