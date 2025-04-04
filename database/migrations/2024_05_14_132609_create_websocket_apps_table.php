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
        Schema::create('websocket_apps', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('app_key');
            $table->text('app_secret');
            $table->integer('ping_interval')->nullable();
            $table->json('allowed_origins')->default('["*"]');
            $table->integer('max_message_size')->default(10_000);
            $table->json('options')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websocket_apps');
    }
};
