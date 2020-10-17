<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->comment("Имя");
            $table->string('middle_name')->comment("Отчество");
            $table->string('last_name')->comment("Фамилия");
            $table->string('affiliation')->comment("Организация");
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('trust_factor')->comment("Фактор доверия")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
