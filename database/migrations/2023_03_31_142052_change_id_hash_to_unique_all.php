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
        Schema::table('users', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('subdistricts', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('order_methods', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('umkm_files', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('order_has_product_types', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('order_has_product_type_details', function (Blueprint $table) {
            $table->unique('id_hash');
        });

        Schema::table('app_versions', function (Blueprint $table) {
            $table->unique('id_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_id_hash_unique');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique('roles_id_hash_unique');
        });

        Schema::table('subdistricts', function (Blueprint $table) {
            $table->dropUnique('subdistricts_id_hash_unique');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->dropUnique('product_types_id_hash_unique');
        });

        Schema::table('order_methods', function (Blueprint $table) {
            $table->dropUnique('order_methods_id_hash_unique');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropUnique('umkms_id_hash_unique');
        });

        Schema::table('umkm_files', function (Blueprint $table) {
            $table->dropUnique('umkm_files_id_hash_unique');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique('orders_id_hash_unique');
        });

        Schema::table('order_has_product_types', function (Blueprint $table) {
            $table->dropUnique('order_has_product_types_id_hash_unique');
        });

        Schema::table('order_has_product_type_details', function (Blueprint $table) {
            $table->dropUnique('order_has_product_type_details_id_hash_unique');
        });

        Schema::table('app_versions', function (Blueprint $table) {
            $table->dropUnique('app_versions_id_hash_unique');
        });
    }
};
