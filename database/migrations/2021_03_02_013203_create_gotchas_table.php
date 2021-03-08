<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGotchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gotchas', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('cost_name')->nullable();
            $table->integer('cost_value')->nullable();
            $table->unsignedBigInteger('picture_id');
            $table->unsignedBigInteger('result_picture_id');
            $table->integer('use_numbers')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("picture_id")->references("id")->on("pictures");
	        $table->foreign("result_picture_id")->references("id")->on("pictures");



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gotchas');
    }
}
