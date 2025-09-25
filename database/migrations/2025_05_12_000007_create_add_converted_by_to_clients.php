<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('converted_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete()->after('description');
            $table->timestamp('converted_at')->nullable()->after('converted_by_user_id');
        });
    }
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('converted_by_user_id');
            $table->dropColumn('converted_at');
        });
    }
};
