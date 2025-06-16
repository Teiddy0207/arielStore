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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên sản phẩm
            $table->decimal('import_price', 10, 2); // Giá nhập
            $table->decimal('price', 10, 2); // Giá bán
            $table->string('material')->nullable(); // Chất liệu
            $table->integer('sale')->nullable(); // Sale (%)
            $table->text('description')->nullable(); // Mô tả
            $table->integer('quantity')->default(0); // Số lượng
            $table->enum('size', ['S', 'M', 'L', 'XL', 'XXL'])->nullable();
            $table->enum('status', ['Đang bán', 'Hết hàng', 'Ngừng bán'])->nullable();
            $table->enum('category', ['Áo', 'Quần', 'Váy', 'Phụ kiện'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
