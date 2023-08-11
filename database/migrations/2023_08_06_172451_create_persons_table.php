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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('family',150);
            $table->integer('personnel_code');
            $table->string('phone',11)->nullable();
            $table->string('mobile',11)->nullable();
            $table->string('net_username')->nullable();
            $table->string('work_place',10)->default('ستاد');
            $table->unsignedBigInteger('assistance')->nullable();
            $table->foreign('assistance')->references('id')->on('assistances');
            $table->string('room_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
