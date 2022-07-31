<?php

use App\Models\Academic;
use App\Models\Program;
use App\Models\Sponsor;
use App\Models\Year;
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
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->foreignIdFor(Program::class);
            $table->foreignIdFor(Sponsor::class);
            $table->foreignIdFor(Academic::class,'last_allowance_receive');
            $table->foreignIdFor(Year::class);
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
