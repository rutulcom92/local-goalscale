<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalScaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_scale', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('description')->index();
            $table->enum('value', ['0','1','2','3','4']);
            $table->bigInteger('goal_id')->unsigned();
            $table->enum('is_active', ['0', '1'])->comment('0=>Blocked, 1=>Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
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
        Schema::dropIfExists('goal_scale');
    }
}
