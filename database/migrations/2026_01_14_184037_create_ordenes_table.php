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
    Schema::create('ordenes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('users');
        $table->foreignId('mesa_id')->constrained('mesas'); // <--- Ahora sí existe
        $table->decimal('total', 10, 2)->default(0);
        $table->decimal('cargo_extra', 10, 2)->default(0);
        $table->string('motivo_extra')->nullable(); 
        $table->enum('estatus', ['pendiente', 'cocinando', 'listo', 'pagado', 'cancelado'])->default('pendiente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */

public function down(): void
{
    Schema::dropIfExists('ordenes');
}
};
