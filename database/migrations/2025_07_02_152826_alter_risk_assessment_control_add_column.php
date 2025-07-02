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
        Schema::table('risk_assessment', function (Blueprint $table) {
            $table->unsignedBigInteger('risk_assessment_control_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_assessment', function (Blueprint $table) {
            $table->dropColumn('risk_assessment_control_id');
        });
    }
};
