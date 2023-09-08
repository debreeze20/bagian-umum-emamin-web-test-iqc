<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
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
                    'id'   => config('env.role.developer'),
                    'name' => 'Developer',
                    'slug' => 'developer'
                ],
                [
                    'id'   => config('env.role.admin'),
                    'name' => 'Administrator',
                    'slug' => 'admin'
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('roles')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'slug' => $value['slug'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('roles')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE roles_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
