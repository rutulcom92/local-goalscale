<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable()->index();
            $table->bigInteger('tag_type_id')->nullable()->unsigned();
            $table->bigInteger('tag_group_id')->nullable()->unsigned();
            $table->bigInteger('org_type_id')->nullable()->unsigned();
            $table->enum('is_active', ['0', '1'])->comment('0 => Inactive, 1 => Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tag_type_id')->references('id')->on('tag_types')->onDelete('cascade');
            $table->foreign('tag_group_id')->references('id')->on('tag_groups')->onDelete('cascade');
            $table->foreign('org_type_id')->references('id')->on('org_types')->onDelete('cascade');
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
        Schema::dropIfExists('tags');
    }
}
