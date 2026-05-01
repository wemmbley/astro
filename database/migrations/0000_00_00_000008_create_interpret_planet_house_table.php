<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('interpret_planet_house');
    }
};
