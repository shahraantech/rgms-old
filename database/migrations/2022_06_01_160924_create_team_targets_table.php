<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_targets', function (Blueprint $table) {
            $table->id();
            $table->integer('target_id');
            $table->integer('manager_id');
            $table->integer('agent_id');
            $table->string('from_date');
            $table->string('to_date');
         
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
        Schema::dropIfExists('team_targets');
    }
}
