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
        // Schema::create('completo_os', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('omClaro', 55);
        //     $table->string('osClaro', 55);
        //     $table->integer('fotoAntes');
        //     $table->integer('fotoDurante');
        //     $table->integer('fotoDepois');
        //     $table->text('obs');
        //     $table->integer('idUnicoClusterComple')->unique();
        //    // $table->foreign('idUnicoClusterComple')->references('idUnicoCluster')->on('cadastro_os');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completo_os');
    }
};
