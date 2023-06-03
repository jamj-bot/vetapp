<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id'); // info del pet, info del diagnóstico, info del owner e info veterinario
            $table->string('order', 10)->unique();
            $table->date('date');
            $table->date('expiry')->nullable();
            $table->boolean('repeat')->default(0);
            $table->string('number_of_repeats')->nullable();
            $table->string('interval_between_repeats')->nullable();
            $table->string('further_information', 600)->nullable();
            $table->boolean('voided')->default(0);
            $table->timestamps();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('consultations')
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
        Schema::dropIfExists('prescriptions');
    }
}
