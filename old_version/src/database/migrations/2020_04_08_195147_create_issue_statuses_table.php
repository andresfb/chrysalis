<?php

use App\Models\IssueStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name", 20);
        });

        Schema::table('issues', function(Blueprint $table) {
            $table->foreign('status_id')
                ->references('id')->on('issue_statuses')
                ->onDelete('cascade');
        });

        $statuses = [
            'Open',
            'In Progress',
            'Testing',
            'Closed',
        ];

        foreach ($statuses as $status) {
            IssueStatus::create([
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
        Schema::dropIfExists('issue_statuses');
    }
}
