<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('is_active'); // enum column
        });
        
        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('num_users_goals')->index()->default(0)->after('provider_type_id');
            $table->integer('num_users')->index()->default(0)->after('num_users_goals');
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
