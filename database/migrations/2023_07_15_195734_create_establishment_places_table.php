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
        Schema::create('establishment_places', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::unprepared(file_get_contents('database/migrations/establishment_places.sql'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishment_places');
    }
};
