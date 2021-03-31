<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProgramsRemoveNotNullContraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('programs', function ($table) {
            \DB::statement('ALTER TABLE programs MODIFY contact_email VARCHAR(255)');
            \DB::statement('ALTER TABLE programs MODIFY contact_phone VARCHAR(255)');
            \DB::statement('ALTER TABLE programs MODIFY address VARCHAR(255)');
            \DB::statement('ALTER TABLE programs MODIFY city VARCHAR(255)');
            \DB::statement('ALTER TABLE programs MODIFY state_id BIGINT(20) unsigned');
            \DB::statement('ALTER TABLE programs MODIFY zip VARCHAR(255)');
            \DB::statement('ALTER TABLE programs MODIFY country_id BIGINT(20) unsigned');
        });

        Schema::enableForeignKeyConstraints();
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
