<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('vaccine_id');
            $table->enum('type', ['Vaccination', 'Revaccination']);
            $table->string('batch_number')->nullable();
            $table->integer('dose_number');
            $table->integer('doses_required');
            $table->date('done');
            $table->boolean('applied')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');

            $table->foreign('vaccine_id')
                ->references('id')
                ->on('vaccines')
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
        Schema::dropIfExists('vaccine_doses');
        $table->dropSoftDeletes();
    }
}
