<?php

use App\Models\Baranggay;
use App\Models\Program;
use App\Models\ScholarshipProgram;
use App\Models\User;
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
        Schema::create('scholars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('status')->comment('1. Pending, 2. Inactive 3. Active 4. Graduate');
            $table->foreignIdFor(Baranggay::class);
            $table->foreignIdFor(ScholarshipProgram::class);
            $table->foreignIdFor(Program::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholars');
    }
};
