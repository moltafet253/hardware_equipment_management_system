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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('products');
            $table->boolean('active')->default(1)->comment('1 => active , 0 => deactive');
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "INSERT INTO companies (id, name, products) VALUES (0, 'ONBOARD', '[\"ONBOARD\"]'); ";
        DB::statement($query);

        $query = "
INSERT INTO companies (name, products)
VALUES
    ('Acbel', '[\"Power\"]'),
('Asus', '[\"Power\",\"Motherboard\",\"Monitor\"]'),
('Coolermaster', '[\"Power\"]'),
('GLT', '[\"Power\"]'),
('Hreen', '[\"Power\"]'),
('Memonex', '[\"Power\"]'),
('RedMax', '[\"Power\"]'),
('SilverStone', '[\"Power\"]'),
('Thermaltake', '[\"Power\"]'),
('Apex', '[\"Case\"]'),
('Comport', '[\"Case\"]'),
('Delux', '[\"Case\"]'),
('Digital', '[\"Case\"]'),
('Elegance', '[\"Case\"]'),
('Gigabyte', '[\"Case\",\"HDD|SSD|M.2\",\"Motherboard\"]'),
('Green', '[\"Case\",\"Power\"]'),
('HP', '[\"Case\",\"Motherboard\",\"Printer\"]'),
('Lexus', '[\"Case\"]'),
('Logic', '[\"Case\"]'),
('Microlab', '[\"Case\"]'),
('Micronet', '[\"Case\"]'),
('mingo', '[\"Case\"]'),
('Napex', '[\"Case\"]'),
('Next', '[\"Case\"]'),
('Optima', '[\"Case\"]'),
('Pascal', '[\"Case\",\"Power\"]'),
('Perfect', '[\"Case\"]'),
('Power Media', '[\"Case\"]'),
('Protect', '[\"Case\"]'),
('RHOMBUS', '[\"Case\"]'),
('Select', '[\"Case\"]'),
('TANUS', '[\"Case\"]'),
('Target', '[\"Case\"]'),
('TSCO', '[\"Case\",\"Power\"]'),
('VANIA', '[\"Case\"]'),
('Viera', '[\"Case\"]'),
('Winext', '[\"Case\"]'),
('Intel', '[\"CPU\",\"Motherboard\"]'),
('AMD', '[\"CPU\"]'),
('Hitachi', '[\"HDD|SSD|M.2\"]'),
('Maxtor', '[\"HDD|SSD|M.2\"]'),
('Samsung', '[\"HDD|SSD|M.2\",\"Monitor\",\"Printer\"]'),
('Seagate', '[\"HDD|SSD|M.2\"]'),
('simmtronics', '[\"HDD|SSD|M.2\"]'),
('Toshiba', '[\"HDD|SSD|M.2\"]'),
('Western Digital', '[\"HDD|SSD|M.2\"]'),
('White Label', '[\"HDD|SSD|M.2\"]'),
('Lexar', '[\"HDD|SSD|M.2\"]'),
('ADATA', '[\"HDD|SSD|M.2\"]'),
('Gloway', '[\"HDD|SSD|M.2\"]'),
('kingmax', '[\"HDD|SSD|M.2\"]'),
('Kingstone', '[\"HDD|SSD|M.2\"]'),
('PNY', '[\"HDD|SSD|M.2\"]'),
('Apacer', '[\"HDD|SSD|M.2\"]'),
('Abit', '[\"Motherboard\"]'),
('Biostar', '[\"Motherboard\"]'),
('ECS', '[\"Motherboard\"]'),
('Foxconn', '[\"Motherboard\"]'),
('MSI', '[\"Motherboard\",\"Monitor\"]'),
('JETWAY', '[\"Motherboard\"]'),
('Asrock', '[\"Motherboard\"]'),
('AOC', '[\"Monitor\"]'),
('CMV', '[\"Monitor\"]'),
('DETIG', '[\"Monitor\"]'),
('GPLUS', '[\"Monitor\"]'),
('LG', '[\"Monitor\"]'),
('Philips', '[\"Monitor\"]'),
('Xvision', '[\"Monitor\"]'),
('Brother', '[\"Printer\"]'),
('Canon', '[\"Printer\"]'),
('Advision', '[\"Scanner\"]'),
('Epson', '[\"Scanner\"]'),
('Fujitsu', '[\"Scanner\"]'),
('Kodak', '[\"Scanner\"]'),
('Plustek', '[\"Scanner\"]'),
('Bizhub', '[\"Copy Machine\"]'),
('Sharp', '[\"Copy Machine\"]')
;
";
        DB::statement($query);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
