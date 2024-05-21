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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('seen')->default(0);
            $table->tinyInteger('approved')->default(0);
         
            $table->foreignId('author_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
