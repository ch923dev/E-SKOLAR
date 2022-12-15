<?php

use App\Models\ScholarshipOrganization;
use App\Models\ScholarshipProgram;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_organization_scholarship_program', function (Blueprint $table) {
            $table->foreignIdFor(ScholarshipProgram::class);
            $table->foreignIdFor(ScholarshipOrganization::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholarship_organization_scholarship_program');
    }
};
