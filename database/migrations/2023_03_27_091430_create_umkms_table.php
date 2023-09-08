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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_hash');
            $table->string('name');
            $table->string('owner_name');
            $table->string('whatsapp_number');
            $table->boolean('is_mbr')->default(false);
            $table->text('address');
            $table->foreignId('subdistrict_id')->constrained('subdistricts', 'id')->cascadeOnDelete();
            $table->string('nik_number')->nullable();
            $table->string('npwp_number')->nullable();
            $table->string('nib_number')->nullable();
            $table->string('bank_reference_number')->nullable();
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
        Schema::dropIfExists('umkms');
    }
};
