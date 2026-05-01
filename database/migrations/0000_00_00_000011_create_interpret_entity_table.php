<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
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
        Schema::dropIfExists('interpret_entity');
    }
};
