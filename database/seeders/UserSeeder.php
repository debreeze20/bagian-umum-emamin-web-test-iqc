<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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
            $password = bcrypt(config('myconfig.default_password'));

            $data = [
                [
                    'id' => 1,
                    'name' => 'Developer',
                    'username' => 'developer',
                    'email' => 'developer@gmail.com',
                    'role_id' => config('env.role.developer'),
                    'password' => $password,
                ],
                [
                    'id' => 2,
                    'name' => 'Bagian Umum',
                    'username' => 'admin',
                    'email' => 'admin@gmail.com',
                    'role_id' => config('env.role.admin'),
                    'password' => $password,
                ]
            ];

            foreach ($data as $key => $value) {
                DB::table('users')->updateOrInsert(['id' => $value['id']], [
                    'id_hash' => Str::uuid(),
                    'name' => $value['name'],
                    'username' => $value['username'],
                    'email' => $value['email'],
                    'password' => $value['password'],
                    'role_id' => $value['role_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $lastId = DB::table('users')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE users_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
