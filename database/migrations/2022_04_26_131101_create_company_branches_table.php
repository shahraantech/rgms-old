<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_branches', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('branch_name');
            $table->string('focal_person');
            $table->string('contact');
            $table->string('lat');
            $table->string('lang');
            $table->string('address');
      
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
        Schema::dropIfExists('company_branches');
    }
}
