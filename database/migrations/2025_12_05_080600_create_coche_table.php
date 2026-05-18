<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coche', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained('marca')->cascadeOnDelete();
            $table->string('modelo', 255);
            $table->text('informacion')->nullable();
            $table->string('potencia', 50)->nullable();
            $table->date('fecha_fabricacion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->string('imagen_path', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coche');
    }
};
