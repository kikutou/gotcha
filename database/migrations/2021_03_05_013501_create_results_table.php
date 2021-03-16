<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gotcha_id');
            $table->text('uid');
            $table->unsignedBigInteger('prize_id');
            $table->integer('status')->default(1)->comment("1: 未発送 2: 発送済み 3: 発送失敗 4: 予想外");
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
        Schema::dropIfExists('results');
    }
}
