<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class modelHasrolesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model_has_roles_array=array(
            [
                'role_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 1,
            ]
        );
        DB::table('model_has_roles')->insert($model_has_roles_array);
    }
}
