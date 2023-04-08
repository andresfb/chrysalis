<?php

use App\Models\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->timestamps();
        });

        Schema::table('projects', function(Blueprint $table) {
            $table->foreign('status_id')
                ->references('id')->on('project_statuses')
                ->onDelete('cascade');
        });

        $statuses = [
            'Active',
            'In Progress',
            'On Track',
            'Delayed',
            'Testing',
            'On Hold',
            'Approved',
            'Cancelled',
            'Planning',
            'Completed',
        ];

        foreach ($statuses as $status) {
            ProjectStatus::create([
               'name' => $status
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
        Schema::dropIfExists('project_statuses');
    }
}
