<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID')->nullable();
            $table->foreign('userID')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('comparment',['Flower','Vegetative','Clone','Mother']);
            $table->integer('comparmentNo');
            $table->string('batchID');
            $table->string('ciltivar');
            $table->date('plantingDate')->nullable();
            $table->date('triggerDate')->nullable();
            $table->date('harvestDate')->nullable();
            $table->date('transplantDate')->nullable();
            $table->date('cloneDate')->nullable();
            $table->date('cullDate')->nullable();
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
        Schema::dropIfExists('batches');
    }
}
