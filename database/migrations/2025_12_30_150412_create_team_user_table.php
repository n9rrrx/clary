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
        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // The Magic Columns for Ali
            $table->string('role')->default('member'); // e.g. 'hr', 'developer'
            $table->decimal('budget_limit', 10, 2)->default(0); // Ali's budget
            $table->json('allowed_tabs')->nullable(); // Stores ["ProjectResource", "InvoiceResource"]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_user');
    }
};
