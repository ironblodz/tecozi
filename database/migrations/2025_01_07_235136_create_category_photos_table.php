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
        Schema::create('category_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('portfolio_categories')->onDelete('cascade');
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_photos');
    }

};
