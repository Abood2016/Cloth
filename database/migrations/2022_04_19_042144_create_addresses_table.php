<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('city_id');

            $table->foreign('city_id')->references('id')->on('cities');

            $table->unsignedBigInteger('country_en_id');
            $table->foreign('country_en_id')->references('id')->on('countries_en');
         
            $table->unsignedBigInteger('city_en_id');

            $table->foreign('city_en_id')->references('id')->on('cities_en');
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
        Schema::dropIfExists('addresses');
    }
}
