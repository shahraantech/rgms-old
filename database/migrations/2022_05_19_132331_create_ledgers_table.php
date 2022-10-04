<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->Integer('head_id');
            $table->Integer('account_id');
            $table->string('ac_type');
            $table->string('amount');
            $table->string('current_balance');
            $table->string('trans_type');
            $table->string('narration');
            $table->string('date');
            $table->string('via');
            $table->Integer('auth_id');
            $table->Integer('location_id');
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
        Schema::dropIfExists('ledgers');
    }
}
