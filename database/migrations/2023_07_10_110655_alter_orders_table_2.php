<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_qty');
            $table->dropColumn('total_price');
            $table->dropColumn('total_tax');
            $table->dropColumn('total_final_price');
            $table->dropColumn('destination_address');
            $table->dropColumn('subdistrict_id');
            $table->foreignId('account_code_id')->nullable()->constrained('account_codes', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_qty');
            $table->decimal('total_price', 12, 2);
            $table->decimal('total_tax', 12, 2);
            $table->decimal('total_final_price', 12, 2);
            $table->text('destination_address');
            $table->foreignId('subdistrict_id')->constrained('subdistricts', 'id')->cascadeOnDelete();
            $table->dropColumn('account_code_id');
        });
    }
};
