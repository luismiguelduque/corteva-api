<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Settings\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'image'     => 'default_profile_image.jpg',
            'password' => \Hash::make('123456'),
        ])->assingRole('admin');

        User::create([
            'name'     => 'Guest',
            'email'    => 'guest@gmail.com',
            'image'    => 'default_profile_image.jpg',
            'password' => \Hash::make('123456'),
        ])->assingRole('guest');

        //25 Registros Random
        //User::factory(25)->create();
    }
}
