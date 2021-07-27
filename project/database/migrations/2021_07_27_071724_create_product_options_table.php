<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->enum('milk', ['', 'skim', 'semi', 'whole'])->default('');
            $table->enum('shots', ['', 'single', 'double', 'triple'])->default('');
            $table->enum('size', ['', 'small', 'medium', 'large'])->default('');
            $table->enum('kind', ['', 'chocolate', 'chip', 'ginger'])->default('');
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
        Schema::dropIfExists('product_options');
    }
}
