<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_entities')->nullable();
            $table->foreign('fk_entities')->references('id')->on('entities')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('identification_capacity');
            $table->string('nationality');
            $table->string('country_residence');
            $table->string('profession');
            $table->string('category');
            $table->string('form_establishment')->default(false);
            $table->string('punctuation');
            $table->string('pep')->default(false);
            $table->string('status_residence')->default(false);
            $table->string('identification_capacity_score');
            $table->string('nationality_score');
            $table->string('country_residence_score');
            $table->string('profession_score');
            $table->string('category_score');
            $table->string('form_establishment_score');
            $table->string('pep_score');
            $table->string('status_residence_score');
            $table->string('risklevel')->nullable();
            $table->string('diligence')->nullable();
            $table->string('color')->nullable();
            $table->string('channel')->nullable();
            $table->string('channel_score')->nullable();

            $table->unsignedBigInteger('fk_user')->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('CASCADE')->onUpgrade('CASCADE');
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
        Schema::dropIfExists('type_assessments');
    }
}
