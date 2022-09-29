<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeciesVaccineTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * COMMANDO: php artisan make:migration create_category_product_table --create=category_product
     * la tabla pivote debe estar en singular y aparantemente debe comenzar con la tabla que primero se creó
     * y luego la siguiente.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('species_vaccine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('vaccine_id');
            $table->timestamps();

            $table->foreign('vaccine_id')
                ->references('id')
                ->on('vaccines')
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
        Schema::dropIfExists('species_vaccine');
    }
}
