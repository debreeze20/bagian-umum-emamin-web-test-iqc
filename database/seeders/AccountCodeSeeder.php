<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountCodeSeeder extends Seeder
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
                    'name' => 'Mamin Lapangan',
                    'name_bank' => 'Bank Jatim',
                    'code' => '123456789'
                ],
                [
                    'id' => 2,
                    'name' => 'Mamin Rapat',
                    'name_bank' => 'Bank Jatim',
                    'code' => '123456789'
                ],
                [
                    'id' => 3,
                    'name' => 'Mamin Tamu',
                    'name_bank' => 'Bank Jatim',
                    'code' => '123456789'
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('account_codes')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'name_bank' => $value['name_bank'],
                    'code' => $value['code'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('account_codes')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE account_codes_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
