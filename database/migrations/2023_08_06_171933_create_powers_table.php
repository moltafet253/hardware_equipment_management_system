<?php

use App\Models\Catalogs\Power;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('powers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model')->nullable();
            $table->string('output_voltage');
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });

        $voltages = [
            '400W', '320W', '335W', '370W', '330W', '350W', '380W', '430W', '460W', '470W',
            '300W', '350W', '360W', '420W', '480W', '485W', '500W', '530W', '535W', '550W',
            '580W', '600W', '650W', '685W'
        ];
        $companies = [
            2, 3, 4, 5, 17,
            7, 27, 8, 9, 10, 35
        ];

        foreach ($companies as $company) {
            foreach ($voltages as $voltage) {
                Power::create([
                    'company_id' => $company,
                    'output_voltage' => $voltage,
                ]);
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powers');
    }
};
