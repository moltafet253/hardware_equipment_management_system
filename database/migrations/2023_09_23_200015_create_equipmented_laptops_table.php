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
        Schema::create('equipmented_laptops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->string('delivery_date',20)->nullable();
            $table->string('property_number')->unique();
            $table->unsignedBigInteger('ram1');
            $table->foreign('ram1')->references('id')->on('rams');
            $table->unsignedBigInteger('ram2')->nullable();
            $table->foreign('ram2')->references('id')->on('rams');
            $table->unsignedBigInteger('ram3')->nullable();
            $table->foreign('ram3')->references('id')->on('rams');
            $table->unsignedBigInteger('ram4')->nullable();
            $table->foreign('ram4')->references('id')->on('rams');
            $table->unsignedBigInteger('hdd1');
            $table->foreign('hdd1')->references('id')->on('rams');
            $table->unsignedBigInteger('hdd2')->nullable();
            $table->foreign('hdd2')->references('id')->on('rams');
            $table->unsignedBigInteger('laptop_id');
            $table->foreign('laptop_id')->references('id')->on('laptops');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipmented_laptops');
    }
};
