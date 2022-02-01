<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->bigInteger('company_id')->index('company_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address');
            $table->string('position');
            $table->string('city');
            $table->string('country');
            $table->tinyInteger('status')->default(1)->index('status');
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
        Schema::dropIfExists('employee');
    }
}
