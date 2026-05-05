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

        Schema::create('interpret_planet_sign', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('planet');
            $table->tinyText('sign');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();
        });

        Schema::create('interpret_planet_house', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('planet');
            $table->tinyText('house');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();

            $table->unique(['repository_key', 'planet', 'house', 'lang']);
        });

        Schema::create('interpret_planet_aspect', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('planet');
            $table->tinyText('aspect');
            $table->tinyText('to_planet');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();
        });

        Schema::create('interpret_cuspid_sign', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('house');
            $table->tinyText('sign');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();
        });

        Schema::create('interpret_entity', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('name');
            $table->tinyText('type');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interpret_repositories');
        Schema::dropIfExists('interpret_planet_sign');
        Schema::dropIfExists('interpret_planet_house');
        Schema::dropIfExists('interpret_planet_aspect');
        Schema::dropIfExists('interpret_cuspid_sign');
        Schema::dropIfExists('interpret_entity');
    }
};
