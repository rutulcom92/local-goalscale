<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserDeatailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('gender'); // enum column
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->dateTime('dob')->nullable()->change();
            $table->enum('gender',['M','F','O'])->comment('M => Male, F =>
            Female, O => Other')->nullable()->after('id');
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
