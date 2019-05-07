<?php
use Illuminate\Support\Str;
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
        $user_array=array(
            [
                'name' => 'Jacos Admin',
                'email' => 'admin@jacos.co.jp',
                'password' => bcrypt('Qe75ymSr'),
            ]
        );

        
        DB::table('users')->insert($user_array);
        
    }
}
