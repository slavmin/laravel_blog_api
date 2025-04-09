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
        Schema::create('taggables', function (Blueprint $table): void {
            $table->id();
            $table->foreignUuid('tag_id')
                ->constrained((new App\Models\Tag())->getTable(), 'uuid')
                ->cascadeOnDelete();
            $table->uuidMorphs('taggable');

            // Indexes
            $table->unique(['tag_id', 'taggable_id', 'taggable_type'], 'taggables_ids_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
