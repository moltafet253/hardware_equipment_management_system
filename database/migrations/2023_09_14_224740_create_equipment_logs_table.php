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
        Schema::create('equipment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('equipment_id');
            $table->string('equipment_type');
            $table->unsignedBigInteger('personal_code')->nullable();
            $table->foreign('personal_code')->references('id')->on('persons');
            $table->integer('property_number');
            $table->string('title');
            $table->unsignedBigInteger('operator');
            $table->foreign('operator')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_logs');
    }
};
