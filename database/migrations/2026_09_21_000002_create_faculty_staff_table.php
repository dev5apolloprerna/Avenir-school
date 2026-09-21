<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_staff', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name', 150);
            $table->string('designation', 150);
            $table->text('short_description')->nullable();
            $table->longText('detailed_description')->nullable();
            $table->string('qualification', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_staff');
    }
};