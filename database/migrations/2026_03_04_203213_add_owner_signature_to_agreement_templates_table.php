<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('agreement_templates', function (Blueprint $table) {
            $table->string('owner_signature_path')->nullable()->after('content');
            // optional (kalau nak simpan bila signature diupdate)
            $table->timestamp('owner_signature_updated_at')->nullable()->after('owner_signature_path');
        });
    }

    public function down(): void
    {
        Schema::table('agreement_templates', function (Blueprint $table) {
            $table->dropColumn(['owner_signature_path', 'owner_signature_updated_at']);
        });
    }
};