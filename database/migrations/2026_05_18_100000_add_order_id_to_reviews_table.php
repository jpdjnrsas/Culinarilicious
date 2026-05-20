<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->nullable()
                ->after('food_id')
                ->constrained()
                ->cascadeOnDelete();
        });

        // Allow legacy food reviews to remain, but support order-only reviews too.
        DB::statement('ALTER TABLE `reviews` MODIFY `food_id` BIGINT UNSIGNED NULL;');
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });

        DB::statement('ALTER TABLE `reviews` MODIFY `food_id` BIGINT UNSIGNED NOT NULL;');
    }
};
