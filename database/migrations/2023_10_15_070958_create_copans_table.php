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
        Schema::create('copans', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('amount');
            $table->tinyInteger('amount_type')->default(0)->comment('0=>percentage 1=> amount unit' );
            $table->tinyInteger('type')->default(0)->comment('0=> for all user , 1=> for selected user');
            $table->tinyInteger('status')->default(0);
            $table-> unsignedBigInteger('discount_ceiling')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copans');
    }
};
