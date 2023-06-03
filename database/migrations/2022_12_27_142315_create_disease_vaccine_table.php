<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseVaccineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_vaccine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disease_id');
            $table->unsignedBigInteger('vaccine_id');
            $table->timestamps();

            $table->foreign('vaccine_id')
                ->references('id')
                ->on('vaccines')
                ->onDelete('cascade');

            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases')
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
        Schema::dropIfExists('disease_vaccine');
    }
}
