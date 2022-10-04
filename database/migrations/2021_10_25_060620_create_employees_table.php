<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); 
            $table->integer('desg_id');
            $table->string('name');
            $table->string('father_name');
            $table->string('dob');
            $table->string('cnic');
            $table->string('phone');
            $table->string('grade');
            $table->string('bank_ac_no');
            $table->string('marital_status');
            $table->string('nationality');
            $table->string('gross_salary');
            $table->string('doj');
            $table->integer('prob_period');
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
        Schema::dropIfExists('employees');
    }
}
