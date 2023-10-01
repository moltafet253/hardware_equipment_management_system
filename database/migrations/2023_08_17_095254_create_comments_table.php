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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->unsignedBigInteger('device');
            $table->foreign('device')->references('id')->on('devices');
            $table->string('title');
            $table->integer('ticket_number')->nullable();
            $table->json('jobs')->nullable();
            $table->text('description');
            $table->boolean('status')->default(1)->comment('0 For In Progress | 1 For Completed');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
