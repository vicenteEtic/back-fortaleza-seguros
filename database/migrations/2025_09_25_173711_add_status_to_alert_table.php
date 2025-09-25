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
        Schema::table('alert', function (Blueprint $table) {
            $table->string('is_active')->default(true)->after('id'); 
        });
    }

    public function down(): void
    {
        Schema::table('alert', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
