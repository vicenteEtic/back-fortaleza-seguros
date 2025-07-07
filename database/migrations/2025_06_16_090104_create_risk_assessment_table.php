<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risk_assessment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('identification_capacity')->nullable();
            $table->unsignedBigInteger('form_establishment')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->tinyInteger('status_residence')->nullable();
            $table->unsignedBigInteger('profession')->nullable();
            $table->boolean('pep')->default(0);
            $table->unsignedBigInteger('country_residence')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('channel')->nullable();
            $table->unsignedBigInteger('score')->nullable();
            $table->string('color')->nullable();
            $table->string('risk_level')->nullable();
            $table->string('diligence')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessment');
    }
};
