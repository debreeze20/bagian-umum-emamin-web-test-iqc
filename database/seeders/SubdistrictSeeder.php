<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubdistrictSeeder extends Seeder
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
                    'name' => 'Tegalsari'
                ],
                [
                    'id' => 2,
                    'name' => 'Simokerto'
                ],
                [
                    'id' => 3,
                    'name' => 'Genteng'
                ],
                [
                    'id' => 4,
                    'name' => 'Bubutan'
                ],
                [
                    'id' => 5,
                    'name' => 'Gubeng'
                ],
                [
                    'id' => 6,
                    'name' => 'Gunung Anyar'
                ],
                [
                    'id' => 7,
                    'name' => 'Sukolilo'
                ],
                [
                    'id' => 8,
                    'name' => 'Tambaksari'
                ],
                [
                    'id' => 9,
                    'name' => 'Mulyorejo'
                ],
                [
                    'id' => 10,
                    'name' => 'Rungkut'
                ],
                [
                    'id' => 11,
                    'name' => 'Tenggilis Mejoyo'
                ],
                [
                    'id' => 12,
                    'name' => 'Benowo'
                ],
                [
                    'id' => 13,
                    'name' => 'Pakal'
                ],
                [
                    'id' => 14,
                    'name' => 'Asemrowo'
                ],
                [
                    'id' => 15,
                    'name' => 'Sokomanunggal'
                ],
                [
                    'id' => 16,
                    'name' => 'Tandes'
                ],
                [
                    'id' => 17,
                    'name' => 'Sambikerep'
                ],
                [
                    'id' => 18,
                    'name' => 'Lakarsantri'
                ],
                [
                    'id' => 19,
                    'name' => 'Bulak'
                ],
                [
                    'id' => 20,
                    'name' => 'Kenjeran'
                ],
                [
                    'id' => 21,
                    'name' => 'Semampir'
                ],
                [
                    'id' => 22,
                    'name' => 'Pabean Cantian'
                ],
                [
                    'id' => 23,
                    'name' => 'Krembangan'
                ],
                [
                    'id' => 24,
                    'name' => 'Wonokromo'
                ],
                [
                    'id' => 25,
                    'name' => 'Wonocolo'
                ],
                [
                    'id' => 26,
                    'name' => 'Wiyung'
                ],
                [
                    'id' => 27,
                    'name' => 'Karang Pilang'
                ],
                [
                    'id' => 28,
                    'name' => 'Jambangan'
                ],
                [
                    'id' => 29,
                    'name' => 'Gayungan'
                ],
                [
                    'id' => 30,
                    'name' => 'Dukuh Pakis'
                ],
                [
                    'id' => 31,
                    'name' => 'Sawahan'
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('subdistricts')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('subdistricts')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE subdistricts_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
