<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Settings\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        $records = [
            ['name' => 'admin',       'description' => 'Administrador', 'is_active' => 1],
            ['name' => 'guest',       'description' => 'Guest',         'is_active' => 1],
        ];

        foreach ($records as $key => $record)
        { Role::create($record); }
    }
}
