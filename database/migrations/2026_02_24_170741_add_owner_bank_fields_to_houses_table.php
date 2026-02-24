<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->string('property_type', 50)->nullable()->after('address');

            $table->string('owner_full_name')->nullable()->after('property_type');
            $table->string('owner_ic_no', 20)->nullable()->after('owner_full_name');

            $table->string('bank_name', 100)->nullable()->after('owner_ic_no');
            $table->string('bank_account_no', 50)->nullable()->after('bank_name');

            $table->text('remarks')->nullable()->after('bank_account_no');
        });
    }

    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn([
                'property_type',
                'owner_full_name',
                'owner_ic_no',
                'bank_name',
                'bank_account_no',
                'remarks',
            ]);
        });
    }
};