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

        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->integer('follow_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->integer('like_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('video_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_url', 255)->nullable();
            $table->string('caption', 255)->nullable();
            $table->integer('author_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('pushes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->index();
            $table->string('content', 255)->nullable();
            $table->string('status', 255)->nullable()->index();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->index();
            $table->integer('video_id')->nullable()->index();
            $table->string('content', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
