<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficialOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficial_owners', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_type_assessment')->nullable();
            $table->foreign('fk_type_assessment')->references('id')->on('type_assessments')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('name')->nullable();
            $table->string('pep')->nullable();
            $table->id();
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
        Schema::dropIfExists('beneficial_owners');
    }
}
