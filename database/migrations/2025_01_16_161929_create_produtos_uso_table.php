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
        Schema::create('produtos_uso', function (Blueprint $table) {
            $table->id();
            $table->integer('idProdutoDesc');
            $table->string('QuantidadeProd');
            $table->integer('idCidade');
            $table->integer('idEstrangeiro');
            $table->integer('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_uso');
    }
};
