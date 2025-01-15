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
        Schema::create('cadastro_os', function (Blueprint $table) {
            $table->id();
            $table->string('Equipe')->nullable(false);
            $table->string('data')->nullable(false);
            $table->integer('cluster')->nullable(false);
            $table->string('endereco')->nullable(false);
            $table->string('classes')->nullable(false);
            $table->time('hoInicio')->nullable(false);
            $table->time('horFim')->nullable(false);
            $table->string('solClaro')->nullable(false);
            $table->string('Prefixo')->nullable(false);
            $table->string('NumPrefixo')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadastro_os');
    }
};
