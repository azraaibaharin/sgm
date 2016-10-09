<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nuna_text');
            $table->string('nuna_img');
            $table->string('babyhood_text');
            $table->string('babyhood_img');
            $table->string('about_text');
            $table->string('tagline_text');
            $table->string('tagline_img');
            $table->string('event_text');
            $table->string('event_img');
            $table->string('potm_text');
            $table->string('potm_img');
            $table->string('facebook_url');
            $table->string('twitter_url');
            $table->string('contact_email');
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
        Schema::dropIfExists('homes');
    }
}
