<?php

use App\Models\Attachment;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum("cover_type", ["youtube", "image"])->nullable();
            $table->foreignIdFor(Attachment::class, "cover_attachment")->nullable();
            $table->longText("text");
            $table->string("attachments")->nullable();
            $table->enum("task_type", ["check", "radio", "short_answer", "long_answer", "theory"])->default("theory");
            $table->jsonb("task_data")->nullable();
            $table->foreignIdFor(Module::class, "module_id");
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
        Schema::dropIfExists('tasks');
    }
}
