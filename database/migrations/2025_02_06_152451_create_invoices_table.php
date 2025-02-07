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
            $table->integer('invoice_no');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('item');
            $table->text('description');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 4, 2)->default(0);
            $table->decimal('tax')->default(0);
            $table->timestamp('invoice_date');
            $table->timestamp('due_date')->nullable();
            $table->longText('note')->nullable();
            $table->longText('terms')->nullable();
            $table->string('ship_to')->nullable();
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
