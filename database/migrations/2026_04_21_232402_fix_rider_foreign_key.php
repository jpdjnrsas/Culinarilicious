<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // ❌ remove old foreign key (riders table)
            $table->dropForeign(['rider_id']);

            // ✅ attach to users table instead
            $table->foreign('rider_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['rider_id']);

            // (optional rollback — back to riders table if you really want old design)
            $table->foreign('rider_id')
                ->references('id')
                ->on('riders')
                ->nullOnDelete();
        });
    }
};