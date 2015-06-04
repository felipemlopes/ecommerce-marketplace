<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_shop_has_reviews', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('coffee_shop_id')->unsigned();
            $table->foreign('coffee_shop_id')->references('id')->on('coffee_shops');
            $table->integer('rating');
            $table->text('review');
            $table->timestamps();
            $table->primary(['user_id', 'coffee_shop_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coffee_shop_has_reviews');
    }

}
