<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergement_options', function (Blueprint $table) {
            $table->id();
            $table->integer('hebergement_id');
            $table->integer('commodite_id');
            $table->timestamps();

            // $table->foreign('hebergement_id')->references('id')->on('hebergements')->onDelete('cascade');
            // $table->foreign('commodite_id')->references('id')->on('commodites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hebergement_options');
    }
}
