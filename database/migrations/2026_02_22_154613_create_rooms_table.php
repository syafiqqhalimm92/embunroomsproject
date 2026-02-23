<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained('houses')->onDelete('cascade');

            $table->string('name')->nullable(); // Bilik A / Room 1
            $table->string('room_type')->nullable(); // single / double / master / studio (boleh text)
            $table->decimal('rent_price', 12, 2)->default(0); // harga sewa bilik
            $table->enum('status', ['available','occupied'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};