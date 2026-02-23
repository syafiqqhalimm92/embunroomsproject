<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ic_no', 20)->unique()->after('id');
            $table->string('role', 20)->default('tenant')->after('password'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['ic_no']);
            $table->dropColumn(['ic_no', 'role']);
        });
    }
};
