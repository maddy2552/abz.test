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
            $table->bigIncrements('id');
            $table->string('full_name', 256)->nullable(false);
            $table->string('phone', 25)->nullable(false);
            $table->string('email', 256)->nullable(false);
            $table->bigInteger('position_id')->nullable(false)->unsigned();
            $table->mediumInteger('salary')->nullable(false)->unsigned();
            $table->bigInteger('head')->nullable(true)->unsigned();
            $table->string('photo', 256)->nullable(false);
            $table->bigInteger('admin_created_id')->nullable(false)->unsigned();
            $table->bigInteger('admin_updated_id')->nullable(false)->unsigned();
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
