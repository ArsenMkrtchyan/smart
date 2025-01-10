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
        Schema::create('simlists', function (Blueprint $table) {
            $table->id();
            $table->string('sim_info');
            $table->string('number');
            $table->string('sim_id');
            $table->string('price');
            $table->string('ident_id')->nullable();
            $table->string('mb');
            $table->foreignId('project_id')->nullable()->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('worker_id')->nullable()->references('id')->on('workers')->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->references('id')->on('projects')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simlists');
    }
};
