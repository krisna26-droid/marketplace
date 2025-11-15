<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            // tambahkan kolom
            $table->unsignedBigInteger('order_item_id');

            // hapus unique lama
            $table->dropUnique(['order_id', 'product_id']);

            // unique baru: per item pesanan
            $table->unique(['order_item_id']);

            // foreign key
            $table->foreign('order_item_id')
                  ->references('id')
                  ->on('order_items')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropColumn('order_item_id');
        });
    }
};
