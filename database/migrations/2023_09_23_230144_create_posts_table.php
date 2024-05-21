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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->text('summary');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('commentable')->default(0)->comment('0=>uncommentable , 1=>commentable');
            $table->text('image');
            $table->string('tags');
            $table->text('slug')->unique()->nullable();
            $table->foreignId('category_id')->constrained('post_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
