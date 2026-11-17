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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->default('Administrator');
            $table->string('user_email')->default('admin@school.edu');
            $table->string('role')->default('Super Administrator');
            $table->string('action');
            $table->string('category')->default('General');
            $table->string('resource')->nullable();
            $table->string('ip_address')->default('127.0.0.1');
            $table->string('status')->default('Success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
