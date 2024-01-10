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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['active', 'pending', 'closed'])->default('active');
            $table->text('description');
            $table->float('price');
            $table->string('address');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip', 5);
            $table->string('photo');
            // $table->enum('category', ['house', 'condo', 'townhouse', 'apartment', 'land', 'commercial'])->default('house');
            $table->foreignId('category_id')->constrained();
            // $table->foreignId('category_id')->constrained()->default(1);
            $table->enum('type', ['sale', 'rent'])->default('sale');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->float('sqft');
            $table->float('lot_size');
            $table->integer('year_built');
            $table->integer('parking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
