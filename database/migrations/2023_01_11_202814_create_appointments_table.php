<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('veterinarian_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('start_time', $precision = 0);
            $table->timestamp('end_time_expected', $precision = 0)->nullable();
            //$table->decimal('price_expected', 8, 2)->nullable(); // services booked + products expected
            //$table->decimal('price_full', 8, 2)->nullable(); // services provided + products provided
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('price_final', 8, 2)->nullable(); // services provided + products provided - discount
            $table->boolean('canceled')->nullable();
            $table->string('cancellation_reason')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('veterinarian_id')
                ->references('id')
                ->on('veterinarians')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('appointments');
        $table->dropSoftDeletes();
    }
}
