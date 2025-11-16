<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            // tambahkan kolom order_item_id
            $table->unsignedBigInteger('order_item_id');

            // unique baru untuk per item pesanan
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

            // drop foreign + unique + kolom
            $table->dropForeign(['order_item_id']);
            $table->dropUnique(['order_item_id']);
            $table->dropColumn('order_item_id');
        });
    }
};
