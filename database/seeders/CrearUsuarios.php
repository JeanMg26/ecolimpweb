<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrearUsuarios extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      DB::table('users')->insert([
         'name'     => 'Giancarlo Montalvan',
         'username' => '46532720',
         'email'    => 'jeanmg25@gmail.com',
         'password' => bcrypt('123456'),
         'status'   => '1'
      ]);
   }
}
