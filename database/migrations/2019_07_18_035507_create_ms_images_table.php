<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_area');
            $table->string('nama',50);
            $table->string('caption',150);
            $table->string('file',150);
            $table->tinyInteger('isActive')->default(1);
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
        Schema::dropIfExists('ms_images');
    }
}
