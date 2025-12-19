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
        Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('invoice_no')->unique();
    $table->string('company_name');
    $table->string('company_address')->nullable();
    $table->string('customer_name');
    $table->string('customer_address')->nullable();
    $table->decimal('discount', 8, 2)->default(0);
    $table->decimal('tax', 8, 2)->default(0);
    $table->date('invoice_date');
    $table->date('due_date')->nullable();
    $table->longText('note')->nullable();
    $table->longText('terms')->nullable();
    $table->string('ship_to')->nullable();
    $table->decimal('total', 8,2)->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
