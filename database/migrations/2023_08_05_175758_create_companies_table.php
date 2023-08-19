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
('Winext', '[\"Case\"]');
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
