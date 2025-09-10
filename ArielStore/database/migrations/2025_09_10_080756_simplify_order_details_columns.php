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
        Schema::table('order_details', function (Blueprint $table) {
            foreach (['note','phone','quantity','status','address','email','price'] as $col) {
                if (Schema::hasColumn('order_details', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            if (!Schema::hasColumn('order_details', 'note')) {
                $table->string('note')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'quantity')) {
                $table->integer('quantity')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'status')) {
                $table->integer('status')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('order_details', 'price')) {
                $table->decimal('price', 15, 2)->nullable();
            }
        });
    }
};
