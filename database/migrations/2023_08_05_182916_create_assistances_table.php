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
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('place')->default(0)->comment('0 For Qom - 1 For States');
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "INSERT INTO assistances (id,name) VALUES
                                             (0,'آموزش') ,
                                             (0,'پژوهش') ,
                                             (0,'منابع انسانی') ,
                                             (0,'فناوری اطلاعات') ,
                                             (0,'بین الملل') ,
                                             (0,'تهذیب') ,
                                             (0,'تبلیغ') ,
                                             (0,'اجتماعی سیاسی') ,
                                             (0,'عمران')
                                             ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistances');
    }
};
