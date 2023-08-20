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
                (8, '2002'),
                (8, '2009'),
                (8, 'AVA'),
                (8, 'Cougar'),
                (8, 'Evo Plus'),
                (8, 'Extra 2004'),
                (8, 'Hero 22'),
                (8, 'Magnum'),
                (8, 'Magnum plus'),
                (8, 'Magnum+'),
                (8, 'Magnum2'),
                (8, 'MD 121 Plus'),
                (8, 'Midi 2002'),
                (8, 'midi 2005'),
                (8, 'Midi 2005 Plus'),
                (8, 'Midi 6c28'),
                (8, 'oraman'),
                (8, 'Pars'),
                (8, 'Pars Evo'),
                (8, 'Pars Plus'),
                (8, 'Robin'),
                (8, 'Solaris'),
                (8, 'WEE'),
                (8, '9 Elite Desk 800 G2 SFF'),
                (8, '9 EliteDesk 800 F2 SFF'),
                (8, '12 probit')
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
