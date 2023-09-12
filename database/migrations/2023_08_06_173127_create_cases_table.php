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
            $table->string('model')->nullable();
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });
        $query="INSERT INTO cases (company_id, model) VALUES
	(11, 'No Model'),
	(12, 'No Model'),
	(13, 'No Model'),
	(14, 'No Model'),
	(15, 'No Model'),
	(16, 'No Model'),
	(17, '2002'),
	(17, '2009'),
	(17, 'AVA'),
	(17, 'X7 Cougar'),
	(17, 'Pars Evo'),
	(17, 'Extra 2004'),
	(17, 'Z2 Hero'),
	(17, 'Extra 2004'),
	(17, 'MD 121 Plus'),
	(17, 'Magnum Plus'),
	(17, 'Midi 2005 Plus'),
	(17, 'Midi 6c28'),
	(17, 'Midi 2002'),
	(17, 'Oraman'),
	(17, 'Robin'),
	(17, 'Pars Plus'),
	(17, 'Solaris'),
	(17, 'WEE'),
	(18, 'Elite Desk 800 G2 SFF'),
	(18, 'EliteDesk 800  F2 SFF'),
	(19, 'No Model'),
	(20, 'No Model'),
	(21, 'probit'),
	(22, 'No Model'),
	(23, 'No Model'),
	(24, 'No Model'),
	(25, 'No Model'),
	(79, 'No Model'),
	(26, 'No Model'),
	(27, 'No Model'),
	(28, 'No Model'),
	(29, 'No Model'),
	(30, 'No Model'),
	(31, 'No Model'),
	(32, 'No Model'),
	(33, 'No Model'),
	(34, 'No Model'),
	(35, 'No Model'),
	(36, 'No Model'),
	(37, 'No Model'),
	(38, 'No Model');
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
