<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();

            // Address
            $table->text('address')->nullable();     // lebih sesuai dari string untuk alamat panjang
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();

            // Jenis Kediaman
            $table->string('property_type', 50)->nullable();

            // Owner
            $table->string('owner_full_name')->nullable();
            $table->string('owner_ic_no', 20)->nullable();

            // Bank
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account_no', 50)->nullable();

            // Unit / rental info
            $table->unsignedInteger('room_count')->nullable();
            $table->decimal('house_rent_price', 10, 2)->nullable();

            // Remarks
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};