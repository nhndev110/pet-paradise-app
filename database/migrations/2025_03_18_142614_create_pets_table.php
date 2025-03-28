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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->boolean('is_male')->nullable()->comment('true: Đực, false: Cái');
            $table->tinyInteger('age')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('status', ['available', 'sold', 'reserved'])
                ->default('available');
            $table->string('image_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
