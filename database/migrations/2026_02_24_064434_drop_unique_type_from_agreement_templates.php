<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('agreement_templates', function (Blueprint $table) {
            $table->dropUnique(['type']); // remove unique index on type
        });
    }

    public function down(): void
    {
        Schema::table('agreement_templates', function (Blueprint $table) {
            $table->unique('type'); // add back if rollback
        });
    }
};
