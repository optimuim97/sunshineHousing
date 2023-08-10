<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('type_logement');
            $table->string('categorie');
            $table->string('ville');
            $table->string('commune');
            $table->string('description');
            $table->string('adresse');
            $table->integer('id_user');
            $table->date('date_disponibilite');
            $table->integer('nbre_personne');
            $table->integer('nbre_lit');
            $table->integer('nbre_sale_bain');
            $table->double('prix');
            $table->double('lat');
            $table->double('long');
            $table->enum('status', ['disponible', 'non disponible'])->default('disponible');
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
        Schema::dropIfExists('hebergements');
    }
}
