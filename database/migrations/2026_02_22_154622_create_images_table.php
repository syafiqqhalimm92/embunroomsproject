<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('imageable_type'); // polymorphic type
            $table->unsignedBigInteger('imageable_id'); // polymorphic id
            $table->string('path'); // storage path
            $table->string('disk')->default('public'); // optional
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();

            $table->index(['imageable_type','imageable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
