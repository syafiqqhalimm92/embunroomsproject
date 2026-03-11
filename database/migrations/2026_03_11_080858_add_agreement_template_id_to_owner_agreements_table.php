<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('owner_agreements', function (Blueprint $table) {
            $table->foreignId('agreement_template_id')
                ->nullable()
                ->after('house_id')
                ->constrained('agreement_templates')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owner_agreements', function (Blueprint $table) {
            $table->dropForeign(['agreement_template_id']);
            $table->dropColumn('agreement_template_id');
        });
    }
};
