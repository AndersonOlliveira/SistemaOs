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
          Schema::table('descritivo_produtos', function (Blueprint $table) {
           $table->integer('fkidClasses')->nullable(true);

     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {  Schema::table('descritivo_produtos', function (Blueprint $table) {
        $table->Drocolum('fkidClasses');

    });
}
};
