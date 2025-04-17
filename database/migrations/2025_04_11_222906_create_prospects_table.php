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
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('comment')->nullable();
            $table->enum('status', ['new', 'contacted', 'interested', 'converted', 'lost', 'client'])->default('new');
            $table->string('source_acquisition')->nullable(); // Supprimé "after 'status'"
            $table->enum('priority', ['low', 'medium', 'high'])->nullable(); // Supprimé "after 'source_acquisition'"
            $table->foreignId('collaborator_id')->nullable()->constrained('users')->nullOnDelete(); // Supprimé "after 'priority'"
            $table->timestamps();

            $table->foreignId('list_id')->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospects');
    }
};
