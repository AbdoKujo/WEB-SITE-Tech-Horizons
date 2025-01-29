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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('article_id')->constrained()->onDelete('cascade'); // Foreign key to articles table
            $table->tinyInteger('rating')->unsigned()->nullable(); // Rating from 1 to 5 (nullable for comments)
            $table->text('comment')->nullable(); // Comment text (nullable for ratings)
            $table->enum('type', ['rating', 'comment'])->default('rating'); // Type of interaction: rating or comment
            $table->enum('state', ['public', 'deleted'])->default('public'); // State of the interaction: public or deleted
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};