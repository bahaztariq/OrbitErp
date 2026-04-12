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
        // Fix Conversations
        Schema::table('conversations', function (Blueprint $table) {
            if (!Schema::hasColumn('conversations', 'title')) {
                $table->string('title')->nullable()->after('name');
            }
            if (!Schema::hasColumn('conversations', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        // Fix Orders
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('client_id')->constrained('suppliers')->onDelete('set null');
            }
            if (!Schema::hasColumn('orders', 'order_date')) {
                $table->dateTime('order_date')->nullable()->after('supplier_id');
            }
            if (!Schema::hasColumn('orders', 'delivery_date')) {
                $table->dateTime('delivery_date')->nullable()->after('order_date');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->after('delivery_date');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('total_amount');
            }
        });

        // Fix Clients
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'status')) {
                $table->string('status')->nullable()->after('country');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id', 'order_date', 'delivery_date', 'total_amount', 'notes']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
