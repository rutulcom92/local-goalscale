<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            // $table->dropColumn('gender'); // enum column
            $table->dropColumn('avg_goal_change');
            $table->dropColumn('num_goals');
            $table->dropColumn('num_users');
            $table->dropColumn('num_users_goals');
        });

        Schema::table('user_details', function (Blueprint $table) {
            // $table->foreign('program_id')->references('id')->on('programs');
            $table->integer('avg_goal_change')->nullable()->index();
            $table->integer('num_goals')->nullable()->index();
            $table->integer('num_users_goals')->nullable()->index();
            $table->integer('num_users')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            // $table->dropColumn('gender'); // enum column
            $table->dropForeign(['provider_type_id']);
        });
    }
}
