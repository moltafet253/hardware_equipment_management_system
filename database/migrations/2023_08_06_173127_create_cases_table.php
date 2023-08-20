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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->timestamps();
            $table->softDeletes();
        });
        $query="INSERT INTO cases (company_id, model)
                VALUES
                (17, '2002'),
                (17, '2009'),
                (17, 'AVA'),
                (17, 'Cougar'),
                (17, 'Evo Plus'),
                (17, 'Extra 2004'),
                (17, 'Hero 22'),
                (17, 'Magnum'),
                (17, 'Magnum plus'),
                (17, 'Magnum+'),
                (17, 'Magnum2'),
                (17, 'MD 121 Plus'),
                (17, 'Midi 2002'),
                (17, 'midi 2005'),
                (17, 'Midi 2005 Plus'),
                (17, 'Midi 6c28'),
                (17, 'oraman'),
                (17, 'Pars'),
                (17, 'Pars Evo'),
                (17, 'Pars Plus'),
                (17, 'Robin'),
                (17, 'Solaris'),
                (17, 'WEE'),
                (17, '9 Elite Desk 800 G2 SFF'),
                (17, '9 EliteDesk 800 F2 SFF'),
                (17, '12 probit')
                ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
