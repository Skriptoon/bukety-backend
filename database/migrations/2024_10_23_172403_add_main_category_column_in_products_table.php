<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private const string TABLE_NAME = 'products';
    private const string COLUMN_NAME = 'main_category_id';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->foreignId(self::COLUMN_NAME)
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->dropColumn(self::COLUMN_NAME);
        });
    }
};
