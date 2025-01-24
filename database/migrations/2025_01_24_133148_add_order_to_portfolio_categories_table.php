<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('id');
        });
    }

    public function down()
    {
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
