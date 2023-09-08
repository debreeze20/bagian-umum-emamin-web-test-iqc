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
        Schema::create('order_has_umkm_product_type_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_hash');
            $table->foreignId('order_has_umkm_product_type_id')->constrained('order_has_umkm_product_types', 'id')->cascadeOnDelete();
            $table->foreignId('subdistrict_id')->constrained('subdistricts', 'id')->cascadeOnDelete();
            $table->text('destination_address');
            $table->integer('qty');
            $table->decimal('total_price', 20, 2);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_has_umkm_product_type_details');
    }
};
