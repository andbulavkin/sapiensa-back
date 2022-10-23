<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldNameToSubsratesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsrate_targets', function (Blueprint $table) {
            $table->renameColumn('ciltivar', 'cultivar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsrate_targets', function (Blueprint $table) {
            $table->renameColumn('cultivar', 'ciltivar');
        });
    }
}
