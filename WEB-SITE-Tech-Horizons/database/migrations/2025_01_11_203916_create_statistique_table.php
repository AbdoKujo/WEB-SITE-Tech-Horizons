<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatistiqueTable extends Migration
{
    public function up()
    {
        Schema::create('statistique', function (Blueprint $table) {
            $table->id();
            $table->integer('abonnes_count');
            $table->integer('articles_count');
            $table->integer('responsables_count');
            $table->integer('site_usage_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('statistique');
    }
}
