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
            'name'     => 'Admin User',
            'email'    => 'admin@user.com',
            'password' => Hash::make('12341234'),
            'is_admin' => true,
        ]);

        DB::table('users')->insert([
            'name'     => 'Common User',
            'email'    => 'common@user.com',
            'password' => Hash::make('12341234'),
            'is_admin' => false,
        ]);
    }
}
