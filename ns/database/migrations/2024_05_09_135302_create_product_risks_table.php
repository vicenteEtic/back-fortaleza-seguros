<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_risks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_type_assessment')->nullable();
            $table->foreign('fk_type_assessment')->references('id')->on('type_assessments')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('product_risk_id');
            $table->string('name');
            $table->string('score');
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
        Schema::dropIfExists('product_risks');
    }
}
