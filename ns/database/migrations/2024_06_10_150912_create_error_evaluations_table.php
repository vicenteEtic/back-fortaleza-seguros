<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_entities')->nullable();
            $table->foreign('fk_entities')->references('id')->on('entities')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('identification_capacity')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_residence')->nullable();
            $table->string('profession')->nullable();
            $table->string('category')->nullable();
            $table->string('form_establishment')->default(false);
            $table->string('punctuation')->nullable();
            $table->string('pep')->default(false)->nullable();
            $table->string('status_residence')->default(false)->nullable();
            $table->string('identification_capacity_score')->nullable();
            $table->string('nationality_score')->nullable();
            $table->string('country_residence_score')->nullable();
            $table->string('profession_score')->nullable();
            $table->string('category_score')->nullable();
            $table->string('form_establishment_score')->nullable();
            $table->string('pep_score')->nullable();
            $table->string('status_residence_score')->nullable();
            $table->string('risklevel')->nullable();
            $table->string('diligence')->nullable();
            $table->string('color')->nullable();
            $table->string('channel')->nullable();
            $table->string('channel_score')->nullable();
            $table->unsignedBigInteger('fk_user')->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('fk_error')->nullable();
            $table->foreign('fk_error')->references('id')->on('error_dates')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->boolean('status')->default(false);
            $table->string('risk_level')->nullable();

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
        Schema::dropIfExists('error_evaluations');
    }
}
