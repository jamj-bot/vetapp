<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pet_id');
            $table->string('age');
            $table->decimal('weight', 7, 3);
            $table->decimal('temperature', 4, 2);
            $table->integer('oxygen_saturation_level')->nullable();
            $table->enum('capillary_refill_time', ['Less than 1 second', '1-2 seconds', 'Longer than 2 seconds']);
            $table->integer('heart_rate');
            $table->enum('pulse', ['Strong and synchronous with each heart beat', 'Irregular', 'Bounding', 'Weak or absent']);
            $table->integer('respiratory_rate');
            $table->enum('reproductive_status', ['Pregnant', 'Lactating', 'Neither']);
            $table->enum('consciousness', ['Alert and responsive', 'Depressed or obtunded', 'Stupor', 'Comatose']);
            $table->enum('hydration', ['Normal', '0-5%', '6-7%', '8-9%', '+10%']);
            $table->enum('pain', ['None', 'Vocalization', 'Changes in behavior', 'Physical changes']);
            $table->enum('body_condition', ['Very thin', 'Thin', 'Normal', 'Fat', 'Very fat']);
            $table->text('problem_statement'); // Anamesis, observations (análisis por sistema) problem list, master list, plan diagnóstico

            // Plan diagnóstico: qué analisis se deben hacer https://www.slideshare.net/faustopantoja9/ecop-labrador
            // https://cvo.org/CVO/media/College-of-Veterinarians-of-Ontario/Resources%20and%20Publications/Templates%20and%20Protocols/SampleCompanionAnimal.pdf

            // Subsecuent: consulta para ver el progreso
            // Closed: caso cerrado
            // In process: en proceso para actualizar información (p. ej. anexar resultados de)


            //$table->string('diagnosis');
            $table->string('types_of_diagnosis');
            $table->enum('prognosis', ['Good', 'Fair', 'Guarded', 'Grave', 'Poor', 'Pending'])->default('Pending');
            $table->enum('color', ['text-success', 'text-olive', 'text-warning', 'text-orange', 'text-danger', 'text-muted'])->default('text-muted');
            $table->text('treatment_plan')->nullable();  // treatment plan, instructions to owner
            $table->enum('consult_status', ['In process', 'Closed'])->default('Closed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
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
        Schema::dropIfExists('consultations');
        $table->dropSoftDeletes();
    }
}
