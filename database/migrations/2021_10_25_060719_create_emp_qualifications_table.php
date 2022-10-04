<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_qualifications', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('qualification');
            $table->string('institute');
            $table->string('from');
            $table->string('to');
            $table->string('cgpa');
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
        Schema::dropIfExists('emp_qualifications');
    }
}
