<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacebookAndInstagramColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homes', function (Blueprint $table) {
            $table->renameColumn('facebook_url', 'facebook_babyhood_url');
            $table->renameColumn('twitter_url', 'twitter_babyhood_url');
            $table->string('facebook_nuna_url');
            $table->string('twitter_nuna_url');
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
            $table->renameColumn('facebook_babyhood_url', 'facebook_url');
            $table->renameColumn('twitter_babyhood_url', 'twitter_url');
            $table->dropColumn('facebook_nuna_url');
            $table->dropColumn('twitter_nuna_url');
        });
    }
}
