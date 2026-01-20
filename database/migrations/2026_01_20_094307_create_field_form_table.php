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
        Schema::create('field_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->boolean('is_required')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_form');
    }
};
