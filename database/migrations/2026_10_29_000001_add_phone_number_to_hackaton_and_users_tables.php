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
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone_number', 25)->nullable()->unique()->after('email');
            });
        }

        if (Schema::hasTable('hackaton_registrations') && !Schema::hasColumn('hackaton_registrations', 'phone_number')) {
            Schema::table('hackaton_registrations', function (Blueprint $table) {
                $table->string('phone_number', 25)->nullable()->after('email');
            });
        }

        if (Schema::hasTable('equity_user_profiles') && !Schema::hasColumn('equity_user_profiles', 'no_hp')) {
            Schema::table('equity_user_profiles', function (Blueprint $table) {
                $table->string('no_hp', 25)->nullable()->after('identifier_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('phone_number');
            });
        }

        if (Schema::hasTable('hackaton_registrations') && Schema::hasColumn('hackaton_registrations', 'phone_number')) {
            Schema::table('hackaton_registrations', function (Blueprint $table) {
                $table->dropColumn('phone_number');
            });
        }

        if (Schema::hasTable('equity_user_profiles') && Schema::hasColumn('equity_user_profiles', 'no_hp')) {
            Schema::table('equity_user_profiles', function (Blueprint $table) {
                $table->dropColumn('no_hp');
            });
        }
    }
};
