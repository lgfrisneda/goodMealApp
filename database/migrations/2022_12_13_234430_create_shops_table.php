<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('options', ['pick-up', 'delivery', 'both'])->nullable();
            $table->string('address')->nullable();
			$table->float('lon')->nullable()->comment('Longitud en grados decimales (wgs84)');
			$table->float('lat')->nullable()->comment('Latitud en grados decimales (wgs84)');

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
        Schema::dropIfExists('shops');
    }
}
