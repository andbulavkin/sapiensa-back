<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstrateTargetSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substrate_target_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subsrateTargetID')->nullable();
            $table->foreign('subsrateTargetID')->references('id')->on('subsrate_targets')->cascadeOnDelete();
            $table->integer('fromDay');
            $table->integer('toDay');
            $table->string('ecMinMax');
            $table->string('phMinMax');
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
        Schema::dropIfExists('substrate_target_subs');
    }
}
