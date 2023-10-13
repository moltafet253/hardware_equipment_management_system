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
        Schema::create('equipmented_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->string('property_number')->unique();
            $table->integer('stamp_number');
            $table->string('computer_name')->nullable();
            $table->string('delivery_date',20)->nullable();
            $table->unsignedBigInteger('case');
            $table->foreign('case')->references('id')->on('cases');
            $table->unsignedBigInteger('power');
            $table->foreign('power')->references('id')->on('powers');
            $table->unsignedBigInteger('motherboard');
            $table->foreign('motherboard')->references('id')->on('motherboards');
            $table->unsignedBigInteger('cpu');
            $table->foreign('cpu')->references('id')->on('cpus');
            $table->unsignedBigInteger('ram1');
            $table->foreign('ram1')->references('id')->on('rams');
            $table->unsignedBigInteger('ram2')->nullable();
            $table->foreign('ram2')->references('id')->on('rams');
            $table->unsignedBigInteger('ram3')->nullable();
            $table->foreign('ram3')->references('id')->on('rams');
            $table->unsignedBigInteger('ram4')->nullable();
            $table->foreign('ram4')->references('id')->on('rams');
            $table->unsignedBigInteger('graphic_card')->nullable();
            $table->unsignedBigInteger('hdd1');
            $table->foreign('hdd1')->references('id')->on('harddisks');
            $table->unsignedBigInteger('hdd2')->nullable();
            $table->foreign('hdd2')->references('id')->on('harddisks');
            $table->unsignedBigInteger('hdd3')->nullable();
            $table->foreign('hdd3')->references('id')->on('harddisks');
            $table->unsignedBigInteger('hdd4')->nullable();
            $table->foreign('hdd4')->references('id')->on('harddisks');
            $table->unsignedBigInteger('odd')->nullable();
            $table->unsignedBigInteger('network_card')->nullable();
//            $table->unsignedBigInteger('network_card2')->nullable();
//            $table->foreign('network_card2')->references('id')->on('network_cards');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipmented_cases');
    }
};
