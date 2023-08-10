<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_customer');
            $table->unsignedBigInteger('id_user_proprio');
            $table->dateTime('date');
            $table->timestamps();

            $table->foreign('id_user_customer')->references('id')->on('users');
            $table->foreign('id_user_proprio')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_lists');
    }
}
