<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinksAndLinkTextsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homes', function (Blueprint $table) {
            $table->string('tagline_link');
            $table->string('tagline_link_text');
            $table->string('event_link');
            $table->string('event_link_text');
            $table->string('potm_link');
            $table->string('potm_link_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homes', function (Blueprint $table) {
            $table->dropColumn('tagline_link');
            $table->dropColumn('tagline_link_text');
            $table->dropColumn('event_link');
            $table->dropColumn('event_link_text');
            $table->dropColumn('potm_link');
            $table->dropColumn('potm_link_text');
        });
    }
}
