<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->bigInteger('user_type_id')->unsigned();
            $table->foreign('user_type_id')->references('id')->on('users_types')->onDelete('cascade');
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable()->index();
            $table->string('password')->nullable()->index();
            $table->string('phone')->index();
            $table->longText('address')->nullable();
            $table->string('city')->nullable()->index();
            $table->bigInteger('state_id')->nullable()->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('zip')->nullable()->index();
            $table->string('record_num')->nullable()->index();
            $table->bigInteger('organization_id')->nullable()->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->nullable()->onDelete('cascade');
            $table->dateTime('last_login')->index();
            $table->enum('is_active', ['0', '1'])->comment('0=>Blocked, 1=>Active')->default('1');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('last_modified_by')->nullable()->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
