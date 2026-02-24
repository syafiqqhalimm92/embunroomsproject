<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agreement_templates', function (Blueprint $table) {
            $table->id();

            // 2 jenis template sahaja
            $table->string('type', 50)->unique();
            // contoh values:
            // owner_to_business  (Tn Rumah)
            // business_to_tenant (Our Tenants)

            $table->string('title')->nullable();
            $table->longText('content')->nullable(); // TinyMCE content (HTML)

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_templates');
    }
};