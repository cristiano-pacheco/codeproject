<?php

use Illuminate\Database\Seeder;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::insert("insert into oauth_clients (id, secret,name,created_at,updated_at) values(?,?,?,?,?)",
            ['appid1','secret','AngularApp',"now()","now()"]);
    }
}
