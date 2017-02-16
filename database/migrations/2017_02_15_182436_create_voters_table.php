<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('voters', function (Blueprint $table) {
            $table->increments('id');

            // UUID
            $table->string('uuid', 37);

            // Voter name
            $table->string('name', 1024);

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
        Schema::drop('voters');
    }
}
