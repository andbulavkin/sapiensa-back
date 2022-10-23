<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('electricalConductivity');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->longText('electricalConductivity')->after('growUnit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['electricalConductivity']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('electricalConductivity', ['Flower', 'Vegetative', 'Clone', 'Mother'])->after('growUnit')->nullable();
        });
    }
}
