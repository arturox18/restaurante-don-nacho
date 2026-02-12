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
    // 1. Grupos de opciones (Ej: "Elige el tamaño", "Elige tu salsa", "Extras")
    Schema::create('grupos_opciones', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Ej: "Salsas", "Tamaño", "Ingredientes Omelette"
        $table->boolean('es_multiple')->default(false); // false = Radio (solo 1), true = Checkbox (varios)
        $table->boolean('es_obligatorio')->default(false);
        $table->integer('maximo_opciones')->nullable(); // Para "Elige hasta 2 ingredientes"
        $table->timestamps();
    });

    // 2. Las opciones individuales (Ej: "Verde", "Rojo", "1/2 Litro")
    Schema::create('opciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_opcion_id')->constrained('grupos_opciones')->onDelete('cascade');
        $table->string('nombre');
        $table->decimal('precio_extra', 10, 2)->default(0); // Si cuesta más (Ej: Pollo extra +$30)
        $table->timestamps();
    });

    // 3. Tabla Pivote: Qué productos tienen qué grupos
    Schema::create('producto_grupo_opcion', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->foreignId('grupo_opcion_id')->constrained('grupos_opciones')->onDelete('cascade');
    });
}

};