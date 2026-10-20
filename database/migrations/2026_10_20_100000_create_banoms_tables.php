<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banoms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('slug')->unique();
            $table->string('category', 160);
            $table->string('title')->nullable();
            $table->string('motto')->nullable();
            $table->text('description');
            $table->string('term', 120)->nullable();
            $table->string('coverage', 255)->nullable();
            $table->string('legal_status', 160)->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('banom_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banom_id')->constrained()->cascadeOnDelete();
            $table->string('position', 160);
            $table->string('name', 160);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['banom_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banom_members');
        Schema::dropIfExists('banoms');
    }
};
