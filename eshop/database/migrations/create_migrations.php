<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'customer']);
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('publisher');
            $table->date('release_date')->nullable();
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->enum('platform', ['PC', 'Play Station', 'Xbox', 'Nintendo', 'Wii']);
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('game_genres', function (Blueprint $table) {
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->primary(['game_id', 'genre_id']);
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->string('image_url');
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->string('video_url');
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('price_paid', 10, 2);
            $table->dateTime('purchase_date')->nullable();
            $table->string('shipping_address');
            $table->enum('shipping_status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->timestamps();
        });

        Schema::create('game_purchases', function (Blueprint $table) {
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->primary(['purchase_id', 'game_id']);
        });

        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->dateTime('added_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('game_purchases');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('trailers');
        Schema::dropIfExists('images');
        Schema::dropIfExists('game_genres');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('games');
        Schema::dropIfExists('users');
    }
};
