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
        Schema::dropIfExists('umkm_has_product_types');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('umkm_has_product_types', function (Blueprint $table) {
            $table->foreignId('umkm_id')->constrained('umkms', 'id')->cascadeOnDelete();
            $table->foreignId('product_type_id')->constrained('product_types', 'id')->cascadeOnDelete();
        });
    }
};
