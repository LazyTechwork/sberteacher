<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            "first_name"   => "Савва",
            "middle_name"  => "Дмитриевич",
            "last_name"    => "Шульгин",
            "affiliation"  => "КФУ",
            "email"        => "savvashu@gmail.com",
            "password"     => \Hash::make("admin"),
            "trust_factor" => 100,
        ]);
        $admin->role()->attach(Role::whereName("admin")->first()->id);
    }
}
