<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('students') && ! Schema::hasColumn('students', 'gender')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('gender', 20)->nullable()->after('email');
            });
        }

        if (Schema::hasTable('teachers') && ! Schema::hasColumn('teachers', 'gender')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('gender', 20)->nullable()->after('email');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('students') && Schema::hasColumn('students', 'gender')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        }

        if (Schema::hasTable('teachers') && Schema::hasColumn('teachers', 'gender')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        }
    }
};
