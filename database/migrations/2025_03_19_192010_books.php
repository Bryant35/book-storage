<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->unsignedBigInteger('category_id');
            $table->json('author_id');
            $table->string('title');
            $table->string('content');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('category_id')->on('category');
            // $table->foreign("author_id")->references("author_id")->on("authors");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['author_id']);
        });

        Schema::dropIfExists('books');
    }
};
