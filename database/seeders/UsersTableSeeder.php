<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([
            'name' => 'admin',
        ],[
            'name' => 'admin',
            'password' => encrypt('1234qwer'),
        ]);
    }
}
