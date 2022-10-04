<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprochedLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approched_leads', function (Blueprint $table) {
            $table->id();
            $table->integer('lead_id');
            $table->integer('agent_id');
            $table->integer('temp_id');
            $table->string('comments');
            $table->date('followup_date');
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
        Schema::dropIfExists('approched_leads');
    }
}
