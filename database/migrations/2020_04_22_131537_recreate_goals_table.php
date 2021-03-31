<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('goals');

        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->index();
            $table->dateTime('goal_start_date')->nullable()->index();
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->bigInteger('participant_id')->nullable()->unsigned();
            $table->bigInteger('provider_id')->nullable()->unsigned();
            $table->bigInteger('goal_change')->nullable();
            $table->dateTime('last_activity_date')->nullable()->index();
            $table->dateTime('goal_closed_date')->nullable()->index();
            $table->enum('is_active', ['0', '1'])->comment('0 => Inactive, 1 => Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')->on('goal_status')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_modified_by')->references('id')->on('users');
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
        Schema::disableForeignKeyConstraints();
        
        Schema::dropIfExists('goals');

        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->dateTime('goal_start_date')->index();
            $table->bigInteger('status_id')->unsigned();
            $table->string('login_id')->index();
            $table->bigInteger('provider_id')->unsigned();
            $table->string('goal_change')->index();
            $table->enum('is_active', ['0', '1'])->comment('0=>Blocked, 1=>Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('status_id')->references('id')->on('goal_status');
            $table->foreign('provider_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_modified_by')->references('id')->on('users');
        });

        Schema::enableForeignKeyConstraints();
    }
}
