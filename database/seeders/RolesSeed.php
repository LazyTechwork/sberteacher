<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(["name" => "admin", "human_name" => "Администратор платформы"]);
        Role::create(["name" => "sberstaff", "human_name" => "Сотрудник Сбера"]);
        Role::create(["name" => "teacher", "human_name" => "Учитель"]);
    }
}
