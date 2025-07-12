<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const string TABLE_NAME = 'additional_products';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->decimal('price');
            $table->string('image');
            $table->boolean('is_active');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create( 'additional_product_order', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('additional_product_id')
                ->constrained(self::TABLE_NAME)
                ->cascadeOnDelete();

            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_product_order');
        Schema::dropIfExists(self::TABLE_NAME);
    }
};