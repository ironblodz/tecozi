<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialPhotosTable extends Migration
{
    /**
     * Execute as migrações.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverter a migração.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_photos');
    }
}

