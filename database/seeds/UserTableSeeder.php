<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        factory(User::class)->create([
           'email' => 'correo@correo.es'
        ]);

        factory(User::class)->create([
            'email' => 'correo2@correo2.es'
        ]);
    }
}
