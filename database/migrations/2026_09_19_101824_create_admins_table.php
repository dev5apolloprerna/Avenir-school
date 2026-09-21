<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('strName', 150);
            $table->string('strEmail', 190)->unique();
            $table->string('strPassword');
            $table->string('strPhoto')->nullable();

            $table->integer('iStatus')->default(1);
            $table->integer('isDelete')->default(0);
            $table->string('strIP', 20)->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};