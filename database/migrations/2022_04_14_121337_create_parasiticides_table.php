<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParasiticidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parasiticides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['External', 'Internal', 'Internal and external']);
            $table->string('manufacturer');
            $table->text('description');
            $table->string('dose'); // cuánta cantidad hay que aplicar por cada dosis
            $table->string('administration'); // cómo aplicar la dosis
            $table->string('primary_application'); // Cuándo vacunar por primera vez
            $table->integer('primary_doses'); // Cuántas dosis aplicar
            $table->string('reapplication_interval'); // Cuándo revacunar
            $table->integer('reapplication_doses'); // Cuántas dosis se necesitan en la reaplicación
            $table->softDeletes();
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
        Schema::dropIfExists('parasiticides');
        $table->dropSoftDeletes();
    }
}
