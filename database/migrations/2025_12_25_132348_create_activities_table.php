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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // Who acts? (The User)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Who is it about? (The Client)
            $table->foreignId('client_id')->constrained()->onDelete('cascade');

            // What happened?
            $table->string('type'); // e.g., 'created', 'comment', 'status_updated'
            $table->text('description'); // e.g., "changed status to active"
            $table->text('body')->nullable(); // For actual comments: "Just talked to client..."

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
