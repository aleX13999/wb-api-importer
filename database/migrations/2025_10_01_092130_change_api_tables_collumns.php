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
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('in_way_to_client')->nullable()->change();
            $table->integer('in_way_from_client')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->tinyInteger('in_way_to_client')->nullable()->change();
            $table->tinyInteger('in_way_from_client')->nullable()->change();
        });
    }
};
