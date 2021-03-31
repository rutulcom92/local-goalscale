<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login'); 
            $table->dropColumn('is_active'); // enum column
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->index()->after('id');
            $table->longText('notes')->nullable()->after('organization_id');
            $table->dateTime('last_login')->nullable()->index()->after('notes');
            $table->enum('is_active', ['0', '1'])->comment('0=>Blocked, 1=>Active')->default('1')->after('last_login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
