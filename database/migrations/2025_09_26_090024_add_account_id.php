<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $wbApiTables = ['sales', 'orders', 'stocks', 'incomes'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->wbApiTables as $wbApiTable) {
            Schema::table($wbApiTable, function (Blueprint $table) {
                $table->foreignId('account_id')->nullable()->after('id')->constrained('accounts')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->wbApiTables as $wbApiTable) {
            Schema::table($wbApiTable, function (Blueprint $table) use ($wbApiTable) {
                $table->dropForeign(['account_id']);
                $table->dropColumn('account_id');
            });
        }
    }
};
