<?php

use Brick\Math\BigInteger;
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
        Schema::create('Clusters', function (Blueprint $table) {
            $table->id();
            $table->string('NomeCluster', 100);
            $table->string('UfCluster',3);
            $table->dateTime('DataCriacaoCluster');
            $table->integer('idUserCricaoCluster');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Clusters');
    }
};
