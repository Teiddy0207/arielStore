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
        Schema::create('show_products', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('name'); // Tên sản phẩm
            $table->decimal('price', 10, 2); // Giá hiện tại
            $table->decimal('original_price', 10, 2)->nullable(); // Giá gốc (nếu có giảm giá)
            $table->text('sizes'); // Các kích thước có sẵn (JSON)
            $table->integer('quantity')->default(1); // Số lượng mặc định
            $table->timestamps(); // created_at và updated_at
            $table->string('image')->nullable(); // Đường dẫn ảnh sản phẩm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_products');
    }
};
