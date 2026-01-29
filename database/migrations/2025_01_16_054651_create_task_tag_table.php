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
        Schema::create('task_tag', function (Blueprint $table) {
            // Definimos las claves foráneas como combinación primaria
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();
                
            $table->foreignId('tag_id')
                ->constrained('tags')
                ->cascadeOnDelete();

            // Agregamos la combinación de las dos claves como clave primaria
            $table->primary(['task_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tag');
    }
};

