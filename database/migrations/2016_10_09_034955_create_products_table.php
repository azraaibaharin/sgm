<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand');
            $table->string('model');
            $table->longText('descripton');
            $table->string('category_id');
            $table->string('image_links'); // comma-separated values
            $table->string('video_links'); // comma-separated values
            $table->string('color');
            $table->string('download_links'); // comma-separated values
            $table->string('weight');
            $table->string('dimension');
            $table->string('weight_capacity');
            $table->string('age_requirement');
            $table->string('awards'); // comma-separated values
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
        Schema::dropIfExists('products');
    }
}
