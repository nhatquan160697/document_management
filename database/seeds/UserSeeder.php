<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'phandanghaivu@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Vu Phan',
            'birth_date' => '1997/03/28',
            'gender' => 1,
            'role' => 2,
            'address' => '08 Ha Van Tinh, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png'
        ]);
        DB::table('users')->insert([
            'email' => 'phandanghaivu2@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Vu Phan2',
            'birth_date' => '1997/03/28',
            'gender' => 1,
            'address' => '08 Ha Van Tinh, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png'
        ]);
    }
}
