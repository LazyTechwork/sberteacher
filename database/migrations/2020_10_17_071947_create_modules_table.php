<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("Название модуля");
            $table->string("subject")->comment("Предмет");
            $table->unsignedSmallInteger("grade")->comment("Класс");
            $table->unsignedSmallInteger("difficulty")->comment("Сложность");
            $table->foreignIdFor(User::class, "user_id");
            $table->enum('status', ['pending', 'sbercheck', 'needcorrections', 'accepted', 'removed'])->default('pending');
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
        Schema::dropIfExists('modules');
    }
}
