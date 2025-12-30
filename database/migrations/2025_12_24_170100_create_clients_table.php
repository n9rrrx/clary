<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // The Workspace this client belongs to (Crucial for Atlassian Style)
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Merging the logic from your deleted files (tags, type, etc)
            $table->string('type')->default('standard'); // standard, vip, etc.
            $table->json('tags')->nullable(); // JSON is better for simple tags than a separate table

            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
