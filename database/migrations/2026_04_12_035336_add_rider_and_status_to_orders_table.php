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
    Schema::table('orders', function (Blueprint $table) {

        if (!Schema::hasColumn('orders', 'rider_id')) {
            $table->foreignId('rider_id')->nullable()->constrained('users')->nullOnDelete();
        }

        if (!Schema::hasColumn('orders', 'delivery_status')) {
            $table->string('delivery_status')->default('pending');
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
