<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGoalTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goal_tag', function (Blueprint $table) {

            $table->dropForeign('goal_tag_program_id_foreign');
            $table->dropColumn('name');
            $table->dropColumn('program_id');

            $table->bigInteger('tag_id')->nullable()->unsigned()->after('id');
            $table->bigInteger('goal_id')->nullable()->unsigned()->after('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
