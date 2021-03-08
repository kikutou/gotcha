<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGotchasPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gotchas_prizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gotcha_id');
            $table->unsignedBigInteger('prize_id');
            $table->integer('frequency');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("gotcha_id")->references("id")->on("gotchas");
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
        Schema::dropIfExists('gotchas_prizes');
    }
}
