<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('document_type', ['letter', 'clearance', 'report']);
            $table->string('document_number', 30);
            $table->unsignedInteger('sequence_number');
            $table->unsignedSmallInteger('year');
            $table->string('title', 200);
            $table->string('sender', 150);
            $table->string('recipient', 150)->nullable();
            $table->date('document_date');
            $table->string('office', 150);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['document_type', 'year', 'sequence_number'], 'doc_type_year_sequence_unique');
            $table->unique(['document_type', 'document_number'], 'doc_type_number_unique');
            $table->index(['document_type', 'document_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
