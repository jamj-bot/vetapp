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
            $table->string('code', 10)->unique();
            $table->string('name', 140)->nullable();
            $table->string('breed', 140)->nullable();
            $table->string('zootechnical_function', 140)->nullable();
            $table->enum('sex', ['Male', 'Female', 'Unknown']);
            $table->date('dob');
            $table->enum('desexed', ['Desexed', 'Not desexed', 'Unknown']);
            $table->boolean('desexing_candidate')->default(1);
            $table->string('alerts', 255)->nullable();
            $table->string('diseases', 255)->nullable();
            $table->string('allergies', 255)->nullable();
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
