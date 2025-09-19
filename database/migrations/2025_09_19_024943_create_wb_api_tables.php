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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('g_number');
            $table->date('date');
            $table->date('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('barcode');
            $table->float('total_price');
            $table->unsignedTinyInteger('discount_percent');
            $table->boolean('is_supply');
            $table->boolean('is_realization');
            $table->string('promo_code_discount')->nullable();
            $table->string('warehouse_name');
            $table->string('country_name');
            $table->string('oblast_okrug_name');
            $table->string('region_name');
            $table->integer('income_id');
            $table->string('sale_id');
            $table->string('odid')->nullable();
            $table->unsignedTinyInteger('spp');
            $table->float('for_pay');
            $table->unsignedInteger('finished_price');
            $table->unsignedInteger('price_with_disc');
            $table->string('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->boolean('is_storno')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('g_number');
            $table->date('date');
            $table->date('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('barcode');
            $table->float('total_price');
            $table->unsignedTinyInteger('discount_percent');
            $table->string('warehouse_name');
            $table->string('oblast');
            $table->integer('income_id');
            $table->string('odid')->nullable();
            $table->string('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->boolean('is_cancel')->nullable();
            $table->date('cancel_dt')->nullable();
            $table->timestamps();
        });

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('barcode');
            $table->integer('quantity');
            $table->boolean('is_supply');
            $table->boolean('is_realization');
            $table->unsignedTinyInteger('quantity_full');
            $table->string('warehouse_name');
            $table->unsignedTinyInteger('in_way_to_client');
            $table->unsignedTinyInteger('in_way_from_client');
            $table->string('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->string('sc_code');
            $table->integer('price');
            $table->integer('discount');
            $table->timestamps();
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id');
            $table->string('number');
            $table->date('date');
            $table->date('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('barcode');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->date('date_close');
            $table->string('warehouse_name');
            $table->string('nm_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('incomes');
    }
};
