<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('author_id')
                ->nullable()
                ->constrained((new App\Models\User())->getTable(), 'uuid')
                ->nullOnDelete();
            $table->string('title')->fulltext();
            $table->string('slug')->unique();
            $table->text('content')->nullable()->fulltext();
            $table->string('description')->nullable()->fulltext();
            $table->string('image')->nullable();
            $table->json('options')->nullable();
            $table->string('type')->nullable()->index();
            $table->boolean('published')->default(true)->index();
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->foreignUuid('parent_id')->after('uuid')
                ->nullable()
                ->constrained((new App\Models\Category())->getTable(), 'uuid')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
