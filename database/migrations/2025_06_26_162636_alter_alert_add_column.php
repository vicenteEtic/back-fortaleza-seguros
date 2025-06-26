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
            $table->string('type')->nullable()->after('id');
            $table->string('list')->nullable()->after('type');
            $table->boolean('is_active')->default(true)->after('list');
            $table->string('origin_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert', function (Blueprint $table) {
            $table->dropColumn(['type', 'list', 'is_active']);
        });
    }
};
