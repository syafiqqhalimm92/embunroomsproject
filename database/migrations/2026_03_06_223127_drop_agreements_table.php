<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('agreements');
    }

    public function down(): void
    {
        // optional kalau nak recreate balik
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
