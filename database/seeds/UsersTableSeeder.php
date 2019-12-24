<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'mark',
                'email' => 'mark@gmail.com',
                'password' => bcrypt('123456'),
                'phone' => '01223377889',
                'role' => 'agent'
            ],
            [
                'name' => 'jack',
                'email' => 'jack@gmail.com',
                'phone' => '01266778892',
                'password' => bcrypt('123456'),
                'role' => 'patient'
            ],
            [
                'name' => 'maria',
                'email' => 'maria@gmail.com',
                'phone' => '01223377881',
                'password' => bcrypt('123456'),
                'role' => 'patient'
            ],
            [
                'name' => 'noha',
                'email' => 'noha@gmail.com',
                'phone' => '01223377885',
                'password' => bcrypt('123456'),
                'role' => 'patient'
            ]
        ]);
    }
}
