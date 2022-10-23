<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsrates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID')->nullable();
            $table->foreign('userID')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('comparment',['Flower','Vegetative','Clone','Mother']);
            $table->integer('comparmentNo');
            // $table->string('batchID');
            $table->unsignedBigInteger('batchID');
            $table->foreign('batchID')->references('id')->on('batches')->cascadeOnDelete();
            $table->string('ciltivar');
            $table->date('samplingDate');
            $table->float('eC');
            $table->float('pH');
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
        Schema::dropIfExists('subsrates');
    }
}
