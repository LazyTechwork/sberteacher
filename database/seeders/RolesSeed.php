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
        Role::create(["name" => "editor", "human_name" => "Сбер Редактор"]);
        Role::create(["name" => "corrector", "human_name" => "Сбер Корректор"]);
        Role::create(["name" => "teacher", "human_name" => "Учитель"]);
    }
}
