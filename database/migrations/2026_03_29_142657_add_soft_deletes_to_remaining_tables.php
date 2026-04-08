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
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('calender_events', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversations', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversation_participants', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('invitations', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('membership', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('calender_events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversation_participants', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('membership', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
