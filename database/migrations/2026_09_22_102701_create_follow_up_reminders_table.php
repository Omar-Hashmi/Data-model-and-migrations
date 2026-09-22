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
        Schema::create('follow_up_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('title', 150);
            $table->string('channel', 20)->default('phone');
            $table->string('status', 20)->default('pending');
            $table->timestamp('due_at');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['lead_id', 'status', 'due_at']);
            $table->index(['contact_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_up_reminders');
    }
};
