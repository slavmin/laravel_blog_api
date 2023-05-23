<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('author_id')->nullable()
                ->constrained((new \App\Models\User())->getTable(), 'uuid')
                ->nullOnDelete();
            $table->string('title')->fulltext();
            $table->string('slug')->unique();
            $table->string('description')->nullable()->fulltext();
            $table->text('content')->nullable()->fulltext();
            $table->text('content_blocks')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('original_author')->nullable()->index();
            $table->string('original_link')->nullable();
            $table->json('options')->nullable();
            $table->string('type')->nullable()->index();
            $table->boolean('featured')->default(false)->index();
            $table->bigInteger('view_count')->nullable();
            $table->boolean('published')->default(true)->index();
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
