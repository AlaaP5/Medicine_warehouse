<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('scientific_name');
            $table->string('commercial_name');
            $table->foreignId('manufacture_id')->constrained('manufactures');
            $table->foreignId('company_id')->constrained('companies');
            $table->integer('quantity_available');
            $table->date('expiry_date');
            $table->integer('price');
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
        Schema::dropIfExists('drugs');
    }
}
