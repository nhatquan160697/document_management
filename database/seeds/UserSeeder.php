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
            'username' => 'systemadmin',
            'email' => 'systemadmin@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Admin Hệ Thống',
            'birth_date' => '2019/05/05',
            'gender' => 1,
            'address' => 'Đại Học Nội Vụ Hà Nội Phân Hiệu Quảng Nam',
            'phone' => '02356263232',
            'avatar' => 'user-default.png',
            'role' => 1,
        ]);
        DB::table('users')->insert([
            'username' => 'phonghanhchinh',
            'email' => 'phonghanhchinh@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Tài Khoản Hành Chính',
            'birth_date' => '1997/03/28',
            'gender' => 1,
            'role' => 2,
            'address' => '08 Tran Hung Dao, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png',
            'role' => 2,
        ]);
        DB::table('users')->insert([
            'username' => 'nguyenquang',
            'email' => 'nguyenquang@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Nguyen Quang',
            'birth_date' => '1997/03/28',
            'gender' => 1,
            'address' => '08 Ha Van Tinh, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png',
            'role' => 2,
        ]);
        DB::table('users')->insert([
            'username' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Test User',
            'birth_date' => '1997/06/16',
            'gender' => 1,
            'address' => '08 Ha Van Tinh, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png',
            'role' => 3,
        ]);
        DB::table('users')->insert([
            'username' => 'uyquyen',
            'email' => 'uyquyen@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'name' => 'Vu Phan',
            'birth_date' => '1997/03/28',
            'gender' => 1,
            'address' => '08 Ha Van Tinh, Da Nang',
            'phone' => '0354525110',
            'avatar' => 'user-default.png',
            'role' => 3,
            'delegacy' => 1,
        ]);
    }
}
