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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        $query="insert into jobs (title) values
                               ('تعویض رم'),
                               ('تعویض هارد'),
                               ('تعویض پاور'),
                               ('تعویض مانیتور'),
                               ('تعویض کیبورد'),
                               ('تعویض موس'),
                               ('شارژ کارتریج پرینتر'),
                               ('تعمیر پرینتر'),
                               ('شارژ کارتریج دستگاه کپی'),
                               ('تعویض ویندوز'),
                               ('نصب نرم افزارهای کاربردی'),
                               ('مشکل یابی نرم افزار')
                               ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
