<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('image')->nullable()->index()->after('id');
            $table->longText('notes')->nullable()->after('country_id');
            $table->dateTime('date_added')->nullable()->index()->after('notes');
            $table->string('record_num')->nullable()->index()->after('date_added');
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
