<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('patients'); }
};
