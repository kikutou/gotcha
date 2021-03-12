<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminUserToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            \App\Models\User::create(
            	[
		            "name" => "管理員",
		            "email" => "admin@admin.com",
	                "password" => \Illuminate\Support\Facades\Hash::make("admin")
                ]
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
			\App\Models\User::query()->where("email", "admin@admin.com")->first()->delete();
        });
    }
}
