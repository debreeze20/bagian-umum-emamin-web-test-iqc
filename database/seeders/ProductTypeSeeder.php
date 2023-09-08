<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $data = [
                [
                    'id' => 1,
                    'name' => 'Nasi Kotak VIP',
                    'price' => 20000
                ],
                [
                    'id' => 2,
                    'name' => 'Nasi Kotak VVIP',
                    'price' => 22000
                ],
                [
                    'id' => 3,
                    'name' => 'Snack VIP',
                    'price' => 10000
                ],
                [
                    'id' => 4,
                    'name' => 'Snack VVIP',
                    'price' => 15000
                ],
                [
                    'id' => 5,
                    'name' => 'Air Mineral Botol',
                    'price' => 5000
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('product_types')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'price' => $value['price'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('product_types')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE product_types_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
