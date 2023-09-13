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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->integer('screen_size');
            $table->string('cpu');
            $table->integer('ram1');
            $table->integer('ram2')->nullable();
            $table->integer('ram3')->nullable();
            $table->integer('ram4')->nullable();
            $table->string('hdd1');
            $table->string('hdd2')->nullable();
            $table->string('graphic_card')->default('onboard');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
