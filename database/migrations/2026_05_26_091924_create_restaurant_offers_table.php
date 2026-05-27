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
        Schema::create('restaurant_offers', function (Blueprint $table) {

    $table->id();

    $table->foreignId('restaurant_id')
          ->constrained('users')
          ->onDelete('cascade');

    $table->string('offer_text');

    $table->string('banner')->nullable();

     $table->timestamp('expire_at')->nullable();
    $table->boolean('is_active')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_offers');
    }
};
