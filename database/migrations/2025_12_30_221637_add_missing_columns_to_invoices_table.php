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
        Schema::table('invoices', function (Blueprint $table) {
            // Add client_id foreign key (required for invoice-client relationship)
            $table->foreignId('client_id')->nullable()->after('team_id')->constrained()->cascadeOnDelete();
            
            // Add project_id foreign key (nullable, invoices can exist without projects)
            $table->foreignId('project_id')->nullable()->after('client_id')->constrained()->cascadeOnDelete();
            
            // Add invoice_number (replaces or works alongside reference_number)
            $table->string('invoice_number')->nullable()->after('user_id');
            
            // Add issue_date
            $table->date('issue_date')->nullable()->after('invoice_number');
            
            // Add financial columns (subtotal, tax, total)
            $table->decimal('subtotal', 10, 2)->nullable()->after('due_date');
            $table->decimal('tax', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total', 10, 2)->nullable()->after('tax');
            
            // Add notes column
            $table->text('notes')->nullable()->after('total');
            
            // Add unique index on invoice_number
            $table->unique('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['project_id']);
            $table->dropUnique(['invoice_number']);
            $table->dropColumn([
                'client_id',
                'project_id',
                'invoice_number',
                'issue_date',
                'subtotal',
                'tax',
                'total',
                'notes',
            ]);
        });
    }
};
