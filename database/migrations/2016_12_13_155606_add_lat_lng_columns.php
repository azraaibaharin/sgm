<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLngColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn("location");
            $table->double("lat");
            $table->double("lng");
            $table->string("city");
            $table->string("state");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string("location");
            $table->dropColumn("lat");
            $table->dropColumn("lng");
            $table->dropColumn("city");
            $table->dropColumn("state");
        });
    }
}
