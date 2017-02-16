<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrumVoterPivotTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrum_voter', function (Blueprint $table) {

            // Points vote
            $table->integer('points_vote')->nullable();

            // Reference user
            $table->integer('scrum_id')->unsigned()->index();
            $table->foreign('scrum_id')->references('id')->on('scrums')->onDelete('cascade');

            // Reference group
            $table->integer('voter_id')->unsigned()->index();
            $table->foreign('voter_id')->references('id')->on('voters')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scrum_voter');
    }

}
