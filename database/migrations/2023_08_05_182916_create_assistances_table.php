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

        $query = "INSERT INTO assistances (name) VALUES
                                                ('امور طلاب و دانش آموختگان'),
                                                ('معاونت آموزش'),
                                                ('معاونت تهذیب و تربیت'),
                                                ('معاونت پژوهش'),
                                                ('تبلیغ اینترنتی'),
                                                ('حوزه ریاست'),
                                                ('مجتمع تخصصی فقه و قضای اسلامی'),
                                                ('مرکز مشاوره'),
                                                ('عمران'),
                                                ('معاونت منابع انسانی'),
                                                ('مرکز پاسخگویی به شبهات'),
                                                ('برنامه ریزی و نظارت راهبردی'),
                                                ('قائم مقام'),
                                                ('تغذیه'),
                                                ('افق'),
                                                ('ارتباطات و بین الملل'),
                                                ('معاونت تبلیغ و امور فرهنگی'),
                                                ('امور اجتماعی و سیاسی'),
                                                ('انبار کتاب مهدیه'),
                                                ('نخبگان'),
                                                ('تبلیغ'),
                                                ('مرکز فناوری اطلاعات'),
                                                ('امور نخبگان'),
                                                ('اقتصاد مقاومتی'),
                                                ('مطالعات راهبردی'),
                                                ('فناوری'),
                                                ('مجتمع تبلیغ غیرحضوری'),
                                                ('آموزش کاربردی'),
                                                ('امور موقوفات و منابع پایدار'),
                                                ('اداره تعمیرات و نگهداری'),
                                                ('حوزه مدیریت'),
                                                ('مذاهب اسلامی'),
                                                ('معصومیه'),
                                                ('پژوهش'),
                                                ('کتابخانه شهرک مهدیه'),
                                                ('امور صیانتی'),
                                                ('مرکز رسانه و فضای مجازی');

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
