<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('interpret_repositories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('key')->unique();
            $table->string('version');
            $table->integer('stars');
            $table->unsignedBigInteger('author_id');
            $table->dateTime('last_cached_date')->nullable();
            $table->dateTime('publicated_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interpret_repositories');
    }
};
