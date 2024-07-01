<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const string TABLE_NAME = 'products';
    private const string COLUMN_NAME = 'vk_description';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->text(self::COLUMN_NAME)->nullable();
            $table->string('vk_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->dropColumn(self::COLUMN_NAME);
            $table->string('vk_url')->nullable(false)->change();
        });
    }
};
