<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltAddPhoneEmailOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
            $table->dropColumn('city');
        });
        
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('name')->index();
            $table->string('contact_phone')->nullable()->after('contact_email')->index();
            $table->string('image')->nullable()->after('contact_phone')->index();
            $table->string('logo_image')->nullable()->after('image')->index();
            $table->date('date_added')->nullable()->after('image')->index();
            $table->string('address')->nullable()->after('date_added')->index();
            $table->string('city')->nullable()->after('address')->index();
            $table->bigInteger('state_id')->unsigned()->after('city');
            $table->string('zip')->nullable()->after('state_id')->index();
            $table->string('record_num')->nullable()->after('zip')->index();
            $table->bigInteger('num_users')->nullable()->after('record_num')->index();
            $table->bigInteger('num_providers')->nullable()->after('num_users')->index();
            $table->bigInteger('num_goals')->nullable()->after('num_providers')->index();
            $table->bigInteger('avg_goal_change')->nullable()->after('num_goals')->index();
            $table->longText('notes')->nullable()->after('num_providers');
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
