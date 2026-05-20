<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // ONLY drop if exists (prevents crash)
            try {
                $table->dropForeign(['rider_id']);
            } catch (\Exception $e) {
                // ignore if already removed
            }

            $table->foreign('rider_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            try {
                $table->dropForeign(['rider_id']);
            } catch (\Exception $e) {}
        });
    }
};