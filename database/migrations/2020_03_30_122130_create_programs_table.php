<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->bigInteger('organization_id')->unsigned();
            $table->string('contact_email')->index();
            $table->string('contact_phone')->index();
            $table->string('address')->index();
            $table->string('city')->index();
            $table->bigInteger('state_id')->unsigned();
            $table->string('zip')->index();
            $table->bigInteger('country_id')->unsigned();
            $table->enum('is_active', ['0', '1'])->comment('0=>Blocked, 1=>Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('last_modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
