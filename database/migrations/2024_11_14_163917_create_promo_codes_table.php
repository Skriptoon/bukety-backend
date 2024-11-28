<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private const string TABLE_STRING = 'promo_codes';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_STRING, static function (Blueprint $table): void {
            $table->id();
            $table->string('promo_code')->unique();
            $table->integer('discount');
            $table->date('expired_at')->nullable();
            $table->boolean('is_disposable');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_STRING);
    }
};
