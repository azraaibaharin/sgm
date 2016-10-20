<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTwitterInstagramColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homes', function (Blueprint $table) {
            $table->dropColumn('instagram_url');
            $table->renameColumn('twitter_babyhood_url', 'instagram_babyhood_url');
            $table->renameColumn('twitter_nuna_url', 'instagram_nuna_url');
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
            $table->string('instagram_url');
            $table->renameColumn('instagram_babyhood_url', 'twitter_babyhood_url');
            $table->renameColumn('instagram_nuna_url', 'twitter_nuna_url');
        });
    }
}
