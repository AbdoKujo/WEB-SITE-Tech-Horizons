<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'article' or 'theme'
            $table->unsignedBigInteger('item_id'); // ID of the article or theme
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('histories'); // Drop the entire table
    }
};