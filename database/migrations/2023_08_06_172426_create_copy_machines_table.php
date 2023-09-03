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
        Schema::create('copy_machines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model');
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });

        $query="INSERT INTO copy_machines (company_id,model)
VALUES
    (77, 'c452'),
    (78, 'AR-x201'),
    (46, 'AR-5516'),
    (46, 'AR-5631'),
    (46, 'AR-1118'),
    (46, 'AR-205'),
    (46, 'AR-2120J'),
    (46, 'AR-5316E'),
    (46, 'AR-5516'),
    (46, 'AR-M205'),
    (46, 'AR-M305N'),
    (46, 'AR-M350N'),
    (46, 'AR-M351N'),
    (46, 'AR-M405N'),
    (46, 'AR-M420U'),
    (46, 'AR-M450U'),
    (46, 'AR-5520'),
    (46, 'e.studio 305');";
        DB::statement($query);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copy_machines');
    }
};
