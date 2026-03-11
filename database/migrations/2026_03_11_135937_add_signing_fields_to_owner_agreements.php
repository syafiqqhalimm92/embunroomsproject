<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owner_agreements', function (Blueprint $table) {

            $table->string('sign_token')->unique()->after('house_id');
            $table->string('status')->default('draft')->after('utility_deposit');
            $table->timestamp('owner_signed_at')->nullable()->after('owner_signature_path');

        });
    }

    public function down(): void
    {
        Schema::table('owner_agreements', function (Blueprint $table) {

            $table->dropColumn([
                'sign_token',
                'status',
                'owner_signed_at'
            ]);

        });
    }
};
