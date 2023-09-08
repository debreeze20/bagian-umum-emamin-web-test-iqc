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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_hash');
            $table->string('name');
            $table->date('event_date');
            $table->date('delivery_date');
            $table->text('destination_address');
            $table->foreignId('subdistrict_id')->constrained('subdistricts', 'id')->cascadeOnDelete();
            $table->foreignId('order_method_id')->constrained('order_methods', 'id')->cascadeOnDelete();
            $table->integer('total_qty');
            $table->decimal('total_price', 12, 2);
            $table->decimal('total_tax', 12, 2);
            $table->decimal('total_final_price', 12, 2);
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
        Schema::dropIfExists('orders');
    }
};
