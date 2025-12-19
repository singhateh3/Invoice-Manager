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
<<<<<<< HEAD
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

=======
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('invoice_no');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('from');
            $table->string('from_address')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_phone')->nullable();
            $table->string('to');
            $table->string('to_address')->nullable();
            $table->string('to_email')->nullable();
            $table->string('to_phone')->nullable();
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
>>>>>>> 74530e6d76c15b465949f28fddf9fb212adaf1bd
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
