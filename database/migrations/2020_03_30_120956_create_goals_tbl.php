<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->foreign('status_id')->references('id')->on('goal_status')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('goals');
    }
}
