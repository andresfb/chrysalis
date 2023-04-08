<?php

use App\Models\ActivityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::table('activities', function(Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')->on('activity_types')
                ->onDelete('cascade');
        });

        $types = [
            'Created',
            'Updated',
            'Deleted',
            'Assigned',
            'Attached',
            'Tagged',
            'Commented',
        ];

        foreach ($types as $type) {
            ActivityType::create([
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
        Schema::dropIfExists('activity_types');
    }
}
