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
        Schema::create('imageables', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('image_id')
                ->constrained((new \App\Models\Image())->getTable(), 'uuid')
                ->cascadeOnDelete();
            $table->uuidMorphs('imageable');

            // Indexes
            $table->unique(['image_id', 'imageable_id', 'imageable_type'], 'imageables_ids_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageables');
    }
};
