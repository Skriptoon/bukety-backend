<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private const string TABLE_NAME = 'product_ingredients';
    private const string RELATED_TABLE_NAME = 'product_product_ingredient';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create(self::RELATED_TABLE_NAME, static function (Blueprint $table): void {
            $table->foreignId('product_ingredient_id')
                ->constrained(self::TABLE_NAME)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::RELATED_TABLE_NAME);
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
