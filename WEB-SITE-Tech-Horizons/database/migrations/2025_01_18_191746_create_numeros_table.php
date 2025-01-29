<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateNumerosTable extends Migration
{
    public function up()
    {
        Schema::create('numeros', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('numeros');
    }
}
