<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('file_url');
            $table->string('type_file');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_hebergement')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_hebergement')->references('id')->on('hebergements')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
