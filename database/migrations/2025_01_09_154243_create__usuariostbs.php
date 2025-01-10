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
        Schema::create('_usuariostbs', function (Blueprint $table) {
            $table->id();
            $table->primary('id');
            $table->string('nome');
            $table->string('login');
            $table->string('email');
            $table->string('senha');
            $table->integer('nivel');
            $table->string('tipoUser');
            $table->integer('ativo');
            $table->dateTime('data_cadastro');
            $table->dateTime('alterSenha');
            $table->string('recuperar_senha');
            $table->dateTime('dataAlteracaoPerfil');
            $table->integer('idUserAlteracaoPerfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_usuariostbs');
    }
};
