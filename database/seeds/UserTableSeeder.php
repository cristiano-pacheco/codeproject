<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Cristiano Pacheco',
            'email' => 'chris.spb25@gmail.com',
            'password' => bcrypt('123'),
        ]);
        
        factory(User::class,10)->create();
    }
}
