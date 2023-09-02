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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->string('generation', 50)->nullable();
            $table->string('ram_slot_generation', 5)->nullable();
            $table->integer('cpu_slot_type')->nullable();
            $table->integer('cpu_slots_number')->nullable();
            $table->integer('ram_slots_number')->nullable();
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });
        $query = "INSERT INTO motherboards (company_id, model)
VALUES
(56, 'I-G31'),
(56, 'IX38-QuadGT'),
(62, '4Core1600Twins-P35'),
(62, 'G31M-S'),
(62, 'Intel 945P'),
(62, 'P43DE3L'),
(62, 'P85 Pro3'),
(62, 'wolfdalel333d'),
(62, 'Yorkf wolfdale'),
(3, 'B75M-A'),
(3, 'B85 PLUS'),
(3, 'B85-PLUS/USB 3.1'),
(3, 'H610M-A'),
(3, 'H61M-C'),
(3, 'H61M-E'),
(3, 'H81M-C'),
(3, 'M4A78'),
(3, 'M4A78LT-M-LE'),
(3, 'M4A88TD-V EVO/USB3'),
(3, 'M4N78 PRO'),
(3, 'M4N78 SE'),
(3, 'P5G41C-M LX'),
(3, 'P5G41T-M LX'),
(3, 'P5G41T-M LX3'),
(3, 'P5GC-MX'),
(3, 'P5GC-MX/1333'),
(3, 'P5KPL'),
(3, 'P5KPL AM-SE'),
(3, 'P5KPL/1600'),
(3, 'P5KPL-AM'),
(3, 'P5KPL-AM EPU'),
(3, 'P5KPL-SE'),
(3, 'P5LD2-SE'),
(3, 'P5P41T-LE'),
(3, 'P5PL2-E'),
(3, 'P5Q'),
(3, 'P5QC'),
(3, 'P5QL-ASUS-SE'),
(3, 'P6T'),
(3, 'P7P55 LX'),
(3, 'P8B75-V'),
(3, 'P8H61-M LE'),
(3, 'P8H61-M LX'),
(3, 'P8H61-M LX R2.0'),
(3, 'P8H61-M LX2'),
(3, 'P8P67LE'),
(3, 'PRIME B360-PLUS'),
(3, 'PRIME H310M-A R2.0'),
(3, 'PRIME H310-PLUS'),
(3, 'PRIME Z490-P'),
(3, 'TUF GAMING Z590-PLUS WIFI'),
(3, 'Z97-A'),
(3, 'Z97-PRO'),
(57, '945P-A7B'),
(57, 'G41T-M13'),
(57, 'Group G41D3'),
(57, 'Group G41-M7'),
(57, 'Group N68S3+'),
(57, 'Group P41D3'),
(57, 'Group TPower I45'),
(58, '945PT-A2'),
(58, 'A780GM-A'),
(58, 'A785GM-AD3 Black Series'),
(58, 'G41T-M12'),
(58, 'G41T-M13'),
(58, 'Geforce 8200 A Black Series'),
(58, 'H61H2-M3'),
(59, 'A7DA 3 series'),
(59, 'P45A01'),
(59, 'P31_ICH7'),
(16, '8I865GME-775-RH R2.0'),
(16, '945GZM-S2'),
(16, '945PLM-S2'),
(16, 'EP31-DS3L'),
(16, 'EP41-UD3L'),
(16, 'EP43-DS3L'),
(16, 'G31M-S2C'),
(16, 'G31M-S2L'),
(16, 'G41M-ES2L'),
(16, 'G41MT-D3'),
(16, 'G41MT-S2'),
(16, 'G41MT-S2P'),
(16, 'G41MT-S2PT'),
(16, 'GA-H61MA-D2V'),
(16, 'GA-P31-ES3G'),
(16, 'H110M-S2PH-CF'),
(16, 'H170-HD3-CF'),
(16, 'H55M-S2'),
(16, 'H55M-S2H'),
(16, 'H61MA-D2V'),
(16, 'H61M-S2P'),
(16, 'H61M-S2P REV 3.0'),
(16, 'H61M-S2P-R3'),
(16, 'H61M-S2PT'),
(16, 'H61M-S2PV REV 2.2'),
(16, 'H61M-USB3-B3'),
(16, 'H61M-WW'),
(16, 'H81M-S2PT'),
(16, 'H81M-S2PV'),
(16, 'P31-ES3G'),
(16, 'P35-DS3L'),
(16, 'P41T-D3'),
(16, 'P43T-ES3G'),
(16, 'P55-UD3L'),
(16, 'P75-D3'),
(16, '954PL-S3'),
(16, 'Z97-D3H-CF'),
(16, 'Z68A-D3-B3'),
(16, 'Z87-HD3'),
(18, '8054'),
(18, '805D'),
(60, 'MS-7369'),
(60, 'MS-7267'),
(60, 'H61M-P23 (MS-7680)'),
(60, 'G41M-P26 (MS-7592)'),
(60, '880GM-E41 (MS-7623)'),
(61, 'TI41M'),
(61, 'MIG41TM/MIG41TM V2'),
(39, 'H55 (IbexPeak DH)'),
(39, 'G31 (Bearlake) + ICH7)'),
(39, 'DP43TF'),
(39, 'H61MA-D2V'),
(39, '945PL (Lakeport-PL) + ICH7');
";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboards');
    }
};
