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
        Schema::create('indicator_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('score');
            $table->string('risk');
            $table->foreignId('indicator_id')
                ->constrained('indicator')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_type');
    }
};
