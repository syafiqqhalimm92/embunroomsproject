<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->text('address');
            $table->string('state', 100);
            $table->string('city', 100);
            $table->unsignedInteger('room_count')->default(0);
            $table->decimal('house_rent_price', 12, 2)->default(0); // harga sewa house (owner<->business)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
