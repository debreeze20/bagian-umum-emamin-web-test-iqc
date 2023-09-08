<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderMethodSeeder extends Seeder
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
                    'name' => 'Katalog Lokal'
                ],
                [
                    'id' => 2,
                    'name' => 'E-Peken'
                ],
                [
                    'id' => 3,
                    'name' => 'SPL'
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('order_methods')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('order_methods')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE order_methods_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
