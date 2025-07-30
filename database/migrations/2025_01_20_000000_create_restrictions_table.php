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
        Schema::create('restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrepreneur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['temporaire', 'permanente', 'avertissement']);
            $table->integer('duration'); // en jours
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->text('motif');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['entrepreneur_id', 'is_active']);
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restrictions');
    }
}; 