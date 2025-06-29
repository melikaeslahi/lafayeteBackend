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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
