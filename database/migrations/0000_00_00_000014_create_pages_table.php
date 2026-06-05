<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable()->comment('For PHP static const.');
            $table->string('title');
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('page_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('meta_key');
            $table->string('meta_value');
            $table->timestamps();
            $table->index(['page_id', 'meta_key']);
            $table->unique(['page_id', 'meta_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_meta');
    }
};
