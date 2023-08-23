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
        Schema::create('harddisks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('model')->nullable();
            $table->string('capacity', 5);
            $table->string('type', 10)->nullable();
            $table->string('connectivity_type', 10)->nullable();
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "INSERT INTO harddisks (company_id,model,capacity,type,connectivity_type) values
                                                      (43,'980 Pro','1TB','Internal','Onboard'),
                                                      (50,'SU800','256GB','Internal','Onboard'),
                                                      (49,NULL,'128GB','Internal','Onboard'),
                                                      (49,NULL,'250GB','Internal','Onboard'),
                                                      (49,NULL,'256GB','Internal','Onboard'),
                                                      (49,NULL,'512GB','Internal','Onboard'),
                                                      (49,NULL,'1TB','Internal','Onboard'),
                                                      (49,NULL,'2TB','Internal','Onboard'),
                                                      (54,NULL,'128GB','Internal','SATA'),
                                                      (54,NULL,'250GB','Internal','SATA'),
                                                      (54,NULL,'256GB','Internal','SATA'),
                                                      (54,NULL,'512GB','Internal','SATA'),
                                                      (54,NULL,'1TB','Internal','SATA'),
                                                      (54,NULL,'2TB','Internal','SATA'),
                                                      (47,'Green','500GB','Internal','SATA'),
                                                      (47,'Green','1TB','Internal','SATA'),
                                                      (47,'Green','2TB','Internal','SATA'),
                                                      (47,'Blue','500GB','Internal','SATA'),
                                                      (47,'Blue','1TB','Internal','SATA'),
                                                      (47,'Blue','2TB','Internal','SATA'),
                                                      (47,'Purple','500GB','Internal','SATA'),
                                                      (47,'Purple','1TB','Internal','SATA'),
                                                      (47,'Purple','2TB','Internal','SATA')
                                                      ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harddisks');
    }
};
