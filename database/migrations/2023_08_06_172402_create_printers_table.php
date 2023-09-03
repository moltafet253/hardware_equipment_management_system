<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->string('function_type')->default('تک کاره');
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });
        $query = "INSERT INTO printers (company_id, model)
VALUES
    (70, 'HL-1110'),
    (70, 'HL-2320D'),
    (70, 'HL-5054DN'),
    (70, 'HL-5452DN'),
    (70, 'HL-6200W'),
    (70, 'HL-L2320D'),
    (70, 'HL-L6200DW'),
    (71, 'i-sensys LBP3010B'),
    (71, 'i-sensys LBP7018C'),
    (71, 'i-sesnys LBP6300DN'),
    (18, '4350'),
    (18, '1320'),
    (18, 'Enterprise 600 M601'),
    (18, 'Enterprise 600 M602'),
    (18, 'M1522NF'),
    (18, 'P4015N'),
    (18, '1012'),
    (18, '1214'),
    (18, '1300'),
    (18, '2100'),
    (18, '1320'),
    (18, 'Color 5550'),
    (18, 'P2035'),
    (18, 'P2055'),
    (18, 'P2055D'),
    (18, '2420'),
    (18, '4350'),
    (18, '5200'),
    (18, 'Enterprise M553'),
    (18, 'Enterprise M604'),
    (18, 'P1005'),
    (18, 'P1006'),
    (18, 'P1102'),
    (18, 'P1102w'),
    (18, 'P2014'),
    (18, 'P2015'),
    (18, 'Color CP1215'),
    (18, '2055DN'),
    (18, 'P3015'),
    (18, 'P4014'),
    (18, 'P4014N'),
    (18, 'P4015N'),
    (18, 'Pro 200 Color M251N'),
    (18, 'Pro 400 M401a'),
    (18, 'Pro 400M 401d'),
    (71, 'i-sensys LBP7018C'),
    (43, 'ML-2160');
";
        DB::statement($query);

        $query="INSERT INTO printers (company_id, model, function_type)
VALUES
    (70, 'DCP 8065DN', 'چندکاره'),
    (71, 'i-sensys MF4570DN', 'چندکاره'),
    (71, 'i-sensys MF4350D', 'چندکاره'),
    (71, 'i-sensys FAX-L150', 'چندکاره'),
    (71, 'i-sesnys MF4550D', 'چندکاره'),
    (71, 'MFC-L2700DW', 'چندکاره'),
    (18, '1536DNF MFP', 'چندکاره'),
    (18, 'Pro M1132 MFP', 'چندکاره'),
    (18, 'M1214NFH MFP', 'چندکاره'),
    (18, 'M1522NF', 'چندکاره'),
    (43, 'SCX-3405FH', 'چندکاره'),
    (43, 'SCX-4833FD', 'چندکاره'),
    (43, 'SCX-5637FR', 'چندکاره');
";
        DB::statement($query);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
