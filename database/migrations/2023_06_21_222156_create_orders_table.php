<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned(); //producto
            $table->bigInteger('administrator_user_id')->unsigned();  //administrador
            $table->bigInteger('customer_user_id')->unsigned(); //cliente
            $table->date('date');
            //$table->enum('status',['pending', 'processing', 'shipped', 'delivered']); //si toca crearlo
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('administrator_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('customer_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
