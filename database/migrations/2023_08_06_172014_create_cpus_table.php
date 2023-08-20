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
(39, 'Celeron G1610'),
(39, 'Core 2 Duo E6300'),
(39, 'Core 2 Duo E6750'),
(39, 'Core 2 Duo E7300'),
(39, 'Core 2 Duo E7400'),
(39, 'Core 2 Duo E7500'),
(39, 'Core 2 Duo E8400'),
(39, 'Core 2 Quad Q6600'),
(39, 'Core 2 Quad Q6700'),
(39, 'Core 2 Quad Q8200'),
(39, 'Core I3-4160'),
(39, 'Core I3-12100'),
(39, 'Core I3-2120'),
(39, 'Core I3-3210'),
(39, 'Core I3-3220'),
(39, 'Core I3-3240'),
(39, 'Core I3-4150'),
(39, 'Core I3-4160'),
(39, 'Core I3-4170'),
(39, 'Core I3-540'),
(39, 'Core I3-6098P'),
(39, 'Core I3-7100'),
(39, 'Core I3-8100'),
(39, 'Core I3-9100'),
(39, 'Core I5 4460'),
(39, 'Core I5-3570K'),
(39, 'Core I5-4460'),
(39, 'Core I5-6500'),
(39, 'Core I5-6600'),
(39, 'Core I5-760'),
(39, 'Core I7-10700'),
(39, 'Core I7-3000'),
(39, 'Core I7-3000K'),
(39, 'Core I7-3770'),
(39, 'Core I7-4770'),
(39, 'Core I7-4790'),
(39, 'Core I7-4790K'),
(39, 'Core I7-870'),
(39, 'Core I7-930'),
(39, 'Core i9-11900K'),
(39, 'Dual Core E5700'),
(39, 'Pentium 4 524'),
(39, 'Pentium 4 630'),
(39, 'Pentium 4 631'),
(39, 'Pentium 4 641'),
(39, 'Pentium 4 651'),
(39, 'Pentium 4 661'),
(39, 'Pentium 5300'),
(39, 'Pentium D 945'),
(39, 'Pentium Dual Core E2180'),
(39, 'Pentium Dual Core E2200'),
(39, 'Pentium Dual Core E5200'),
(39, 'Pentium Dual Core E5300'),
(39, 'Pentium Dual Core E5400'),
(39, 'Pentium Dual Core E5500'),
(39, 'Pentium Dual Core E5700'),
(39, 'Pentium Dual Core E6300'),
(39, 'Pentium Dual Core E6500'),
(39, 'Pentium Dual Core E6600'),
(39, 'Pentium Dual Core E6700'),
(39, 'Pentium G2020'),
(39, 'Pentium G2030'),
(39, 'Pentium G3220'),
(39, 'Pentium G620'),
(39, 'Pentium G630'),
(39, 'Pentium G645'),
(39, 'Pentium G840'),
(40, 'Athlon 64 X2 5000'),
(40, 'Athlon II X2 240'),
(40, 'Athlon II X2 245'),
(40, 'Athlon II X2 250'),
(40, 'Athlon II X4 620'),
(40, 'Phenom II X2 560'),
(40, 'Phenom II X4 970 Black Edition'),
(40, 'Sempron 145');
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
