<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('stock')->nullable(0);
            $table->double('price', 2)->nullable(0.00);
            $table->integer('discount_percent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
