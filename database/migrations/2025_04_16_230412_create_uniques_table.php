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
        Schema::create('uniques', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained('projects');
            $table->integer('paymanagir_hamar')->nullable();
            $table->date('paymanagir_date')->nullable();
            $table->date('matucman_date')->nullable();
            $table->string('carayutyan_anun')->nullable();
            $table->double('gumar')->nullable();
            $table->date('export_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniques');
    }
};
