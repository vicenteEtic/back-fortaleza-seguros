<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug']);
            $table->string('remote_addr')->nullable();
            $table->string('path_info')->nullable();
            $table->string('user_name')->nullable();
            $table->string('type')->nullable();
            $table->string('userId')->nullable();
            $table->string('http_user_agent')->nullable();
            $table->longText('message')->nullable();
            $table->unsignedBigInteger('id_entity')->nullable();
            $table->foreign('id_entity')->references('id')->on('entities')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
