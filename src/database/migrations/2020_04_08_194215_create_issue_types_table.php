<?php

use App\Models\IssueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_types', function (Blueprint $table) {
            $table->id();
            $table->string("name", 20);
        });

        Schema::table('issues', function(Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')->on('issue_types')
                ->onDelete('cascade');
        });

        $types = [
            'Bug',
            'Improvement',
            'Task',
            'New Feature',
        ];

        foreach ($types as $type) {
            IssueType::create([
                'name' => $type
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
        Schema::dropIfExists('issue_types');
    }
}
