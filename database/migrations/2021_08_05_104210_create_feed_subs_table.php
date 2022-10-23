<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedID')->nullable();
            $table->foreign('feedID')->references('id')->on('feeds')->cascadeOnDelete();
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
        Schema::dropIfExists('feed_subs');
    }
}
