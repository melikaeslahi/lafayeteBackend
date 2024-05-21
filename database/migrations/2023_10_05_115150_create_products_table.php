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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('introduction');
            $table->decimal('weight' , 10 , 2)->nullable();
            $table->decimal('length' , 10 , 1)->nullable();
            $table->decimal('width' , 10 , 1)->nullable();
            $table->decimal('height' , 10 , 1)->nullable();
            $table->decimal('price' , 20 , 3);
            $table->text('slug')->unique()->nullable();
            $table->text('tags');
            $table->text('image');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('marketable')->default(1);
            $table->tinyInteger('marketable_number')->default(0);
            $table->tinyInteger('sold_number')->default(0);
            $table->tinyInteger('frozen_number')->default(0);
            $table->foreignId('category_id')->constrained('product_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
