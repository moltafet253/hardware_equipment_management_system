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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        $query="insert into devices (name) values
                               ('Case'),
                               ('Motherboard'),
                               ('Monitor'),
                               ('CPU'),
                               ('RAM'),
                               ('Graphic Card'),
                               ('HDD/SSD/M.2'),
                               ('Copy Machine'),
                               ('Scanner'),
                               ('LAN/WLAN Card'),
                               ('Network Card'),
                               ('ODD'),
                               ('Power'),
                               ('VOIP'),
                               ('Printer'),
                               ('Headphone'),
                               ('Laptop'),
                               ('Mobile'),
                               ('Modem'),
                               ('Recorder'),
                               ('Router'),
                               ('Speaker'),
                               ('Switch'),
                               ('Tablet'),
                               ('Video Projector'),
                               ('Video Projector Curtain'),
                               ('Webcam')
                               ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
