<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();

            // polymorphic attach (house or room)
            $table->string('agreeable_type');
            $table->unsignedBigInteger('agreeable_id');

            $table->string('agreement_type', 50); // e.g. owner_to_business, business_to_tenant_room

            // owner details (for owner_to_business)
            $table->string('owner_name')->nullable();
            $table->string('owner_ic')->nullable();
            $table->string('owner_phone')->nullable();

            // tenant user (for room agreement) - store user id if tenant is a user in system
            $table->foreignId('tenant_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 20)->default('active'); // active / ended / cancelled

            $table->timestamps();

            $table->index(['agreeable_type','agreeable_id']);
            $table->index(['agreement_type','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};