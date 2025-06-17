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
            $table->unsignedBigInteger('identification_capacity');
            $table->unsignedBigInteger('form_establishment');
            $table->unsignedBigInteger('category');
            $table->tinyInteger('status_residence');
            $table->unsignedBigInteger('profession');
            $table->boolean('pep');
            $table->unsignedBigInteger('country_residence');
            $table->unsignedBigInteger('nationality');
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('channel');
            $table->unsignedBigInteger('score')->nullable();
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
