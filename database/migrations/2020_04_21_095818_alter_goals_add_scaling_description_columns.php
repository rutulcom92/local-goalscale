<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGoalsAddScalingDescriptionColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->text('scale_zero_description')->nullable()->after('goal_change');
            $table->text('scale_one_description')->nullable()->after('scale_zero_description');
            $table->text('scale_two_description')->nullable()->after('scale_one_description');
            $table->text('scale_three_description')->nullable()->after('scale_two_description');
            $table->text('scale_four_description')->nullable()->after('scale_three_description');
        });

        // Full Text Indexes
        DB::statement('CREATE FULLTEXT INDEX goals_scale_zero_description_index ON goals(scale_zero_description)');
        DB::statement('CREATE FULLTEXT INDEX goals_scale_one_description_index ON goals(scale_one_description)');
        DB::statement('CREATE FULLTEXT INDEX goals_scale_two_description_index ON goals(scale_two_description)');
        DB::statement('CREATE FULLTEXT INDEX goals_scale_three_description_index ON goals(scale_three_description)');
        DB::statement('CREATE FULLTEXT INDEX goals_scale_four_description_index ON goals(scale_four_description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn('scale_zero_description');
            $table->dropColumn('scale_one_description');
            $table->dropColumn('scale_two_description');
            $table->dropColumn('scale_three_description');
            $table->dropColumn('scale_four_description');
        });
    }
}
