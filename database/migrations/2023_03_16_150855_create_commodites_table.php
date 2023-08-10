<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodites', function (Blueprint $table) {
            $table->id();
            $table->boolean('wifi')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('tv')->default(false);
            $table->boolean('frigo')->default(false);
            $table->boolean('clim')->default(false);
            $table->boolean('gardien')->default(false);
            $table->string('id_hebergement')->default(false);
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
        Schema::dropIfExists('commodités');
    }
}
