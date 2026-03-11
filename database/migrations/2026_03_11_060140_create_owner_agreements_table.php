<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_agreements', function (Blueprint $table) {

            $table->id();

            // FK ke houses
            $table->foreignId('house_id')->constrained('houses')->cascadeOnDelete();

            // Tarikh agreement
            $table->date('agreement_date')->nullable();

            // Owner details (snapshot data)
            $table->string('owner_name')->nullable();
            $table->string('owner_ic')->nullable();
            $table->string('owner_phone')->nullable();

            // Bank details
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no')->nullable();

            // Address premis
            $table->text('premise_address')->nullable();

            // Tempoh sewa
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // tempoh bulan (calculated)
            $table->integer('tenancy_period_month')->nullable();

            // Harga
            $table->decimal('rent_price',10,2)->nullable();
            $table->decimal('deposit_amount',10,2)->nullable();
            $table->decimal('utility_deposit',10,2)->nullable();

            // Signature
            $table->string('owner_signature_path')->nullable();
            $table->string('tenant_signature_path')->nullable();

            // Extra info
            $table->text('inventory')->nullable();
            $table->text('emergency_contact')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_agreements');
    }
};
