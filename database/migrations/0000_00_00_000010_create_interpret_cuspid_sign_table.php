<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('interpret_cuspid_sign', function (Blueprint $table) {
            $table->id();
            $table->string('repository_key');
            $table->tinyText('house');
            $table->tinyText('sign');
            $table->longText('content');
            $table->tinyText('lang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interpret_cuspid_sign');
    }
};
