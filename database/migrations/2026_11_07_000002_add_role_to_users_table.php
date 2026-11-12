<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add role column to the users table for Filament panel access control.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role')->default('admin')->after('name');
        });

        // Set existing seeded users to correct roles
        DB::table('users')->where('email', 'admin@rimeinterior.com')->update(['role' => 'admin']);
        DB::table('users')->where('email', 'editor@rimeinterior.com')->update(['role' => 'editor']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('role');
        });
    }
};

