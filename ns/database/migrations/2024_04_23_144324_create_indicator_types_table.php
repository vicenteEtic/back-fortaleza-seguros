<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_types', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();;
            $table->string('comment')->nullable();;
            $table->string('risk')->nullable();;
            $table->string('score')->nullable();;
            $table->unsignedBigInteger('fk_indicator')->nullable();
            $table->foreign('fk_indicator')->references('id')->on('indicator_evaluation_matrices')->onDelete('CASCADE')->onUpgrade('CASCADE');
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
        Schema::dropIfExists('indicator_types');
    }
}
