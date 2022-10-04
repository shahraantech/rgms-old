<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_leads', function (Blueprint $table) {
            $table->id();
             $table->integer('lead_id');
             $table->integer('agent_id');
             $table->integer('manager_id');
             $table->string('type');
             $table->integer('status');
             $table->integer('allocate_by');
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
        Schema::dropIfExists('assigned_leads');
    }
}
