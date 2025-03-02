<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('portfolio_images', function (Blueprint $table) {
        $table->string('type')->default('image'); // Pode ser 'image' ou 'video'
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_images', function (Blueprint $table) {
            //
        });
    }
};
