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
        Schema::create('scanners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "INSERT INTO scanners (company_id,model)
VALUES
    (72, 'AD240'),
    (72, 'AV121'),
    (72, 'AV220C2+'),
    (72, 'AV176U'),
    (71, 'Lide 25'),
    (71, 'Lide 110'),
    (71, '8800F'),
    (71, 'Lide 120'),
    (71, 'Lide 210'),
    (71, 'lide 220'),
    (71, 'Lide 400'),
    (71, 'Lide 700F'),
    (73, 'V33'),
    (74, 'Fi-6230'),
    (18, 'ScanJet 4850'),
    (18, 'ScanJet 5590'),
    (18, 'ScanJet 7400C'),
    (18, 'ScanJet G2410'),
    (18, 'ScanJet G3110'),
    (18, 'ScanJet G4010'),
    (75, 'i1220 Plus'),
    (75, 'i2600'),
    (75, 'i2400'),
    (75, 'i2420'),
    (75, 'i3200'),
    (76, 'PL2550');";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scanners');
    }
};
