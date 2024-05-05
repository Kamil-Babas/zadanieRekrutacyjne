<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa_produktu', 100);
            $table->string('producent', 100);
            $table->string('jednostka_ceny', 10);
            $table->float('waga');
            $table->float('srednica');
            $table->float('dlugosc');
            $table->float('szerokosc');
            $table->float('wysokosc');
            $table->float('grubosc');
            $table->string('typ_opakowania', 40);
            $table->string('jednostki_zakupu', 40);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
