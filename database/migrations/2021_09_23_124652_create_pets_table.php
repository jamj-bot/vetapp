<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('species_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->string('zootechnical_function')->nullable();
            $table->enum('sex', ['Male', 'Female', 'Unknown']);
            $table->date('dob');
            $table->enum('neutered', ['Yes', 'No', 'Unknown']);
            $table->string('diseases')->nullable();
            $table->string('allergies')->nullable();
            $table->enum('status', ['Alive', 'Dead'])->default('Alive');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('pets');
        $table->dropSoftDeletes();
    }
}
