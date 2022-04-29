<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDewormingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dewormings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('parasiticide_id');
            $table->enum('type', ['First application', 'Reapplication']);
            $table->string('duration'); // cuánto dura el efecto y se requiere nueva aplicación
            $table->string('withdrawal_period')->nullable();
            $table->integer('dose_number'); // qué número de dosis es
            $table->integer('doses_required'); // cuántas dosis hay que aplica

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');

            $table->foreign('parasiticide_id')
                ->references('id')
                ->on('parasiticides')
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
        Schema::dropIfExists('dewormings');
    }
}
