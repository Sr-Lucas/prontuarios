<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cep');
            $table->string('city');
            $table->string('state');
            $table->string('street');
            $table->string('neighborhood');
            $table->string('number');
            $table->string('complement');
            $table->string('reference');
            $table->boolean('is_deleted')->default(false);

            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients')
                ->onDelete('cascade');

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
        Schema::dropIfExists('patient_addresses');
    }
}
