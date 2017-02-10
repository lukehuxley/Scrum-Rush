<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('scrums', function (Blueprint $table) {
            $table->increments('id');

            // Scrum name
            $table->string('name', 1024);

            // Scrum master
            $table->string('scrum_master', 1024);

            // UUID
            $table->string('uuid', 37);

            // Started
            $table->boolean('started')->default(false);

            // Round open
            $table->boolean('round_open')->default(false);

            // Session ID
            $table->string('session_id', 41);

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
        Schema::drop('scrums');
    }
}
