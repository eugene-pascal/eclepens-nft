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
        $model = new \App\Models\User([
            'name' => 'mr.Pascal',
            'email' => 'webradsupport@gmail.com',
            'password' => Hash::make('odessa77'),
            'status' => '1',
        ]);
        $model->save();
    }
}
