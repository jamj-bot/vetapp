<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('veterinarian_id');
            $table->timestamp('from', $precision = 0);
            $table->timestamp('to', $precision = 0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('veterinarian_id')
                ->references('id')
                ->on('veterinarians')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
        $table->dropSoftDeletes();
    }
}
