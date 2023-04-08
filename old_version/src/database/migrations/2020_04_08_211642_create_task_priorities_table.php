<?php

use App\Models\TaskPriority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreign('priority_id')
                ->references('id')->on('task_priorities')
                ->onDelete('cascade');
        });

        $priorities = [
            'Highest',
            'High',
            'Medium',
            'Low',
            'Lowest',
        ];

        foreach ($priorities as $priority) {
            TaskPriority::create([
                'name' => $priority
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_priorities');
    }
}
