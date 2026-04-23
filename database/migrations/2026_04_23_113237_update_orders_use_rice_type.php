<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');
            $table->foreignId('rice_type_id')->after('customer_name')->constrained('rice_types')->cascadeOnDelete();
            $table->decimal('quantity', 10, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['rice_type_id']);
            $table->dropColumn('rice_type_id');
            $table->foreignId('menu_id')->after('customer_name')->constrained('menus')->cascadeOnDelete();
        });
    }
};