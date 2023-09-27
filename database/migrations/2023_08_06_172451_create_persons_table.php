<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('personnel_code')->nullable();
            $table->string('national_code')->nullable();
            $table->string('phone',11)->nullable();
            $table->string('mobile',11)->nullable();
            $table->string('net_username')->nullable();
            $table->unsignedBigInteger('executive_position')->nullable();
            $table->foreign('executive_position')->references('id')->on('executive_positions');
            $table->unsignedBigInteger('work_place')->default(35);
            $table->foreign('work_place')->references('id')->on('provinces');
            $table->unsignedBigInteger('assistance')->nullable();
            $table->foreign('assistance')->references('id')->on('assistances');
            $table->unsignedBigInteger('establishment_place')->nullable();
            $table->foreign('establishment_place')->references('id')->on('establishment_places');
            $table->string('room_number')->nullable();
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        $query="INSERT INTO persons (id, name, family, personnel_code, national_code, phone, mobile, net_username, work_place, assistance, establishment_place, room_number,adder, created_at, updated_at, deleted_at) VALUES
(1, 'علی', 'حسابی', NULL, '1234567891', NULL, NULL, NULL, 35, 16, 10, '452',1, '2023-08-25 15:04:45', '2023-08-25 15:04:45', NULL);           ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
