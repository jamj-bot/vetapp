<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //nombre de la vacuna
            $table->string('type'); // tipo de vacuna: virus inactuvado, adn mensajero
            $table->string('manufacturer'); // fabricante de la vacuna
            $table->text('description'); // para qupe esta indicada
            $table->enum('status', ['Recommended', 'Optional']); // es recomendada u obligatoria
            $table->string('dosage'); // cuántos ml darle
            $table->string('administration'); // como dárselos
            $table->string('vaccination_schedule'); // Cuándo vacunar por primera vez
            $table->integer('primary_doses'); // Cuántas dosis aplicar en la vacunación
            $table->string('revaccination_schedule'); // Cuándo revacunar
            $table->integer('revaccination_doses'); // Cuántas dosis hay que aplicar en la revacunación
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccines');
        $table->dropSoftDeletes();
    }
}
