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
            'name' => 'Wesley',
            'email' => 'wesleywillians@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        
        factory(User::class,10)->create();
    }
}
