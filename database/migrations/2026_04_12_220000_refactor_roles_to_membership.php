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
        // Add role_id to invitations
        Schema::table('invitations', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('company_id')->constrained('roles')->onDelete('set null');
        });

        // Add role_id to membership
        Schema::table('membership', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('company_id')->constrained('roles')->onDelete('set null');
        });

        // Remove role_id from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add role_id back to users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('password')->nullable()->constrained('roles')->onDelete('set null');
        });

        // Remove from membership
        Schema::table('membership', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        // Remove from invitations
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
