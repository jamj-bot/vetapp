<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParasiticidesSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parasiticides_species', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parasiticide_id');
            $table->unsignedBigInteger('species_id');
            $table->timestamps();

            $table->foreign('parasiticide_id')
                ->references('id')
                ->on('parasiticides')
                ->onDelete('cascade');

            $table->foreign('species_id')
                ->references('id')
                ->on('species')
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
        Schema::dropIfExists('parasiticides_species');
    }
}
