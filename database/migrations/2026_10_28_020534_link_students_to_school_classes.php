<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->nullOnDelete();
        });

        foreach (DB::table('school_classes')->get(['id', 'grade', 'section']) as $schoolClass) {
            DB::table('students')
                ->where('class_name', $schoolClass->grade.$schoolClass->section)
                ->update(['school_class_id' => $schoolClass->id]);
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['class_name']);
            $table->dropColumn('class_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('class_name', 3)->nullable()->index();
        });

        foreach (DB::table('students')->whereNotNull('school_class_id')->get(['id', 'school_class_id']) as $student) {
            $schoolClass = DB::table('school_classes')->where('id', $student->school_class_id)->first(['grade', 'section']);

            if ($schoolClass !== null) {
                DB::table('students')->where('id', $student->id)->update([
                    'class_name' => $schoolClass->grade.$schoolClass->section,
                ]);
            }
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropColumn('school_class_id');
        });
    }
};
