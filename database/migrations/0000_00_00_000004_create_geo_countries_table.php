<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('geo_countries', function (Blueprint $table) {
            $table->id();
            $table->string('geo', 5);
            $table->string('name');
            $table->text('terms');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->unsignedBigInteger('population')->default(0);
            $table->string('timezone')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->timestamps();
            $table->index(['country_code']);
            $table->index(['locale']);
        });
    }
};
