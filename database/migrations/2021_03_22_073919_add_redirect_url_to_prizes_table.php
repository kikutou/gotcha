<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedirectUrlToPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->string('redirect_url')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->dropColumn(['redirect_url']);
        });
    }
}
