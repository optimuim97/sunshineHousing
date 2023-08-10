<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hebergement');
            $table->integer('id_user');
            $table->integer('id_proprio');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->float('montant');
            $table->float('avance');
            $table->float('reste');
            $table->integer('nbre_personne');
            $table->string('status', 50);
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
        Schema::dropIfExists('reservations');
    }
}
