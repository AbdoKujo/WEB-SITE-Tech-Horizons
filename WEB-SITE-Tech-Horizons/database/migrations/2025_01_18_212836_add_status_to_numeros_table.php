<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToNumerosTable extends Migration
{
    public function up()
    {
        Schema::table('numeros', function (Blueprint $table) {
            $table->string('status')->default('privé')->after('description');
        });
    }

    public function down()
    {
        Schema::table('numeros', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}