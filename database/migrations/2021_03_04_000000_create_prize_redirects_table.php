<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_redirects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prize_id');
            $table->text('url_1')->nullable();
	        $table->text('url_2')->nullable();
	        $table->text('url_3')->nullable();
			$table->softDeletes();
            $table->timestamps();

            $table->foreign("prize_id")->references("id")->on("prizes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prize_redirects');
    }
}
