<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServeyRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servey_remarks', function (Blueprint $table) {
            $table->id();
            $table->integer('servey_id');
            $table->string('age');
            $table->string('address');
            $table->string('is_married');
            $table->string('profession');
            $table->string('intrest');
            $table->string('is_dependent');
            $table->string('remarks');
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
        Schema::dropIfExists('servey_remarks');
    }
}
