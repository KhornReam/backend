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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('grade');
            $table->string('section', 10);
            $table->unique(['grade', 'section']);
            $table->timestamps();
        });

        $now = now();
        $classes = [];

        foreach ([10, 11, 12] as $grade) {
            foreach (['A', 'B', 'C'] as $section) {
                $classes[] = [
                    'grade' => $grade,
                    'section' => $section,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('school_classes')->insert($classes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
