<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_dates', function (Blueprint $table) {
            $table->id();
            $table->string('sucess');
            $table->unsignedBigInteger('fk_user')->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('error');
            $table->string('total');
            $table->softDeletes();
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
        Schema::dropIfExists('error_dates');
    }
}
