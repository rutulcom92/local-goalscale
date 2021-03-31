<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltStateNullUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign('organizations_state_id_foreign_key');
            $table->dropColumn('state_id');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->bigInteger('state_id')->nullable()->unsigned()->after('city');
            $table->foreign('state_id', 'organizations_state_id_foreign_key')->references('id')->on('states')->onUpdate('CASCADE')->onDelete('CASCADE');
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
