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
            $table->string('name');
            $table->json('products'); // فیلد products از نوع JSON
            $table->timestamps();
            $table->softDeletes();
        });

        $query = "INSERT INTO companies (id, name, products) VALUES (0, 'ONBOARD', '[\"ONBOARD\"]'); ";
        DB::statement($query);

        $query = "
INSERT INTO companies (name, products)
VALUES
('Apex', '[\"Case\"]'),
('Comport', '[\"Case\"]'),
('Delux', '[\"Case\"]'),
('Digital', '[\"Case\"]'),
('Elegance', '[\"Case\"]'),
('Gigabyte', '[\"Case\"]'),
('Green', '[\"Case\"]'),
('HP', '[\"Case\"]'),
('Lexus', '[\"Case\"]'),
('Logic', '[\"Case\"]'),
('Microlab', '[\"Case\"]'),
('Micronet', '[\"Case\"]'),
('mingo', '[\"Case\"]'),
('Napex', '[\"Case\"]'),
('Next', '[\"Case\"]'),
('Optima', '[\"Case\"]'),
('Pascal', '[\"Case\"]'),
('Perfect', '[\"Case\"]'),
('Power Media', '[\"Case\"]'),
('Protect', '[\"Case\"]'),
('RHOMBUS', '[\"Case\"]'),
('Select', '[\"Case\"]'),
('TANUS', '[\"Case\"]'),
('Target', '[\"Case\"]'),
('TSCO', '[\"Case\"]'),
('VANIA', '[\"Case\"]'),
('Viera', '[\"Case\"]'),
('Winext', '[\"Case\"]'),
('Intel', '[\"CPU\"]'),
('AMD', '[\"CPU\"]'),
('Hitachi', '[\"HDD|SSD|M.2\"]'),
('Maxtor', '[\"HDD|SSD|M.2\"]'),
('Samsung', '[\"HDD|SSD|M.2\"]'),
('Seagate', '[\"HDD|SSD|M.2\"]'),
('simmtronics', '[\"HDD|SSD|M.2\"]'),
('Toshiba', '[\"HDD|SSD|M.2\"]'),
('Western Digital', '[\"HDD|SSD|M.2\"]'),
('White Label', '[\"HDD|SSD|M.2\"]'),
('Lexar', '[\"HDD|SSD|M.2\"]'),
('ADATA', '[\"HDD|SSD|M.2\"]'),
('Gigabyte', '[\"HDD|SSD|M.2\"]'),
('Gloway', '[\"HDD|SSD|M.2\"]'),
('kingmax', '[\"HDD|SSD|M.2\"]'),
('Kingstone', '[\"HDD|SSD|M.2\"]'),
('PNY', '[\"HDD|SSD|M.2\"]'),
('Apacer', '[\"HDD|SSD|M.2\"]')
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
