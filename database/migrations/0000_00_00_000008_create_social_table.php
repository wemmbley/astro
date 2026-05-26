<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_dialogues', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('user_dialogue_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dialogue_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unique(['dialogue_id', 'user_id']);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('user_dialogue_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dialogue_id')->index();
            $table->unsignedBigInteger('author_id')->index();
            $table->text('user_message');
            $table->dateTime('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('user_follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('following_id');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['follower_id', 'following_id']);
        });

        Schema::create('user_friend_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->enum('status', ['pending', 'accepted', 'declined', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->unique(['sender_id', 'receiver_id']);
            $table->index('status');
        });

        Schema::create('user_friends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('friend_id');
            $table->unsignedBigInteger('request_id');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['user_id', 'friend_id']);
            $table->index('user_id');
        });

        Schema::create('user_blacklist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blocker_id');
            $table->unsignedBigInteger('blocked_id');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['blocker_id', 'blocked_id']);
            $table->index('blocker_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_dialogues');
        Schema::dropIfExists('user_dialogue_participants');
        Schema::dropIfExists('user_dialogue_messages');
        Schema::dropIfExists('user_follows');
        Schema::dropIfExists('user_friend_requests');
        Schema::dropIfExists('user_friends');
        Schema::dropIfExists('user_blocks');
    }
};
