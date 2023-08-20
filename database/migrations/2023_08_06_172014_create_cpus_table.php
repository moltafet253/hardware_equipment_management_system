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
        Schema::create('cpus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->integer('generation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "
INSERT INTO cpus (company_id, model)
VALUES
(30, 'Celeron G1610'),
(30, 'Core 2 Duo E6300'),
(30, 'Core 2 Duo E6750'),
(30, 'Core 2 Duo E7300'),
(30, 'Core 2 Duo E7400'),
(30, 'Core 2 Duo E7500'),
(30, 'Core 2 Duo E8400'),
(30, 'Core 2 Quad Q6600'),
(30, 'Core 2 Quad Q6700'),
(30, 'Core 2 Quad Q8200'),
(30, 'Core I3-4160'),
(30, 'Core I3-12100'),
(30, 'Core I3-2120'),
(30, 'Core I3-3210'),
(30, 'Core I3-3220'),
(30, 'Core I3-3240'),
(30, 'Core I3-4150'),
(30, 'Core I3-4160'),
(30, 'Core I3-4170'),
(30, 'Core I3-540'),
(30, 'Core I3-6098P'),
(30, 'Core I3-7100'),
(30, 'Core I3-8100'),
(30, 'Core I3-9100'),
(30, 'Core I5 4460'),
(30, 'Core I5-3570K'),
(30, 'Core I5-4460'),
(30, 'Core I5-6500'),
(30, 'Core I5-6600'),
(30, 'Core I5-760'),
(30, 'Core I7-10700'),
(30, 'Core I7-3000'),
(30, 'Core I7-3000K'),
(30, 'Core I7-3770'),
(30, 'Core I7-4770'),
(30, 'Core I7-4790'),
(30, 'Core I7-4790K'),
(30, 'Core I7-870'),
(30, 'Core I7-930'),
(30, 'Core i9-11900K'),
(30, 'Dual Core E5700'),
(30, 'Pentium 4 524'),
(30, 'Pentium 4 630'),
(30, 'Pentium 4 631'),
(30, 'Pentium 4 641'),
(30, 'Pentium 4 651'),
(30, 'Pentium 4 661'),
(30, 'Pentium 5300'),
(30, 'Pentium D 945'),
(30, 'Pentium Dual Core E2180'),
(30, 'Pentium Dual Core E2200'),
(30, 'Pentium Dual Core E5200'),
(30, 'Pentium Dual Core E5300'),
(30, 'Pentium Dual Core E5400'),
(30, 'Pentium Dual Core E5500'),
(30, 'Pentium Dual Core E5700'),
(30, 'Pentium Dual Core E6300'),
(30, 'Pentium Dual Core E6500'),
(30, 'Pentium Dual Core E6600'),
(30, 'Pentium Dual Core E6700'),
(30, 'Pentium G2020'),
(30, 'Pentium G2030'),
(30, 'Pentium G3220'),
(30, 'Pentium G620'),
(30, 'Pentium G630'),
(30, 'Pentium G645'),
(30, 'Pentium G840'),
(31, 'Athlon 64 X2 5000'),
(31, 'Athlon II X2 240'),
(31, 'Athlon II X2 245'),
(31, 'Athlon II X2 250'),
(31, 'Athlon II X4 620'),
(31, 'Phenom II X2 560'),
(31, 'Phenom II X4 970 Black Edition'),
(31, 'Sempron 145');
";

        DB::statement($query);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpus');
    }
};
