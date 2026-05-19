<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->decimal('medicine_fee', 10, 2)->default(0);
            $table->decimal('test_fee', 10, 2)->default(0);
            $table->decimal('other_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('invoices'); }
};
