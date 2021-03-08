<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('type')->default(1)->comment("1: ゲーム内利用 2: 発送物");
            $table->unsignedBigInteger('picture_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("picture_id")->references("id")->on("pictures");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
