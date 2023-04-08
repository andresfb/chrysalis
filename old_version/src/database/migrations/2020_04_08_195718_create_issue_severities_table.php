<?php

use App\Models\IssueSeverity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueSeveritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_severities', function (Blueprint $table) {
            $table->id();
            $table->string("name", 20);
        });

        Schema::table('issues', function(Blueprint $table) {
            $table->foreign('severity_id')
                ->references('id')->on('issue_severities')
                ->onDelete('cascade');
        });

        $severities = [
            'None',
            'Catastrophic',
            'Critical',
            'Major',
            'Minor',
        ];

        foreach ($severities as $severity) {
            IssueSeverity::create([
                'name' => $severity
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
        Schema::dropIfExists('issue_severities');
    }
}
