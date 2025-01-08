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
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'description']);
        });
    }

};
