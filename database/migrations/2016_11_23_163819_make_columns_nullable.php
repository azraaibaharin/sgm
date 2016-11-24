<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->change();
            $table->string('model')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->decimal('price')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('category_id')->nullable()->change();
            $table->string('image_links')->nullable()->change();
            $table->string('video_links')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('download_links')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->string('dimension')->nullable()->change();
            $table->string('weight_capacity')->nullable()->change();
            $table->string('age_requirement')->nullable()->change();
            $table->string('awards')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->change();
            $table->string('model')->change();
            $table->longText('description')->change();
            $table->decimal('price')->change();
            $table->string('status')->change();
            $table->string('category_id')->change();
            $table->string('image_links')->change(); 
            $table->string('video_links')->change(); 
            $table->string('color')->change();
            $table->string('download_links')->change(); 
            $table->string('weight')->change();
            $table->string('dimension')->change();
            $table->string('weight_capacity')->change();
            $table->string('age_requirement')->change();
            $table->string('awards')->change();
        });
    }
}
