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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('receiver_name', 100);
            $table->string('phone_number', 15);
            $table->string('address_line', 150)->comment('Số nhà và tên đường');
            $table->string('ward', 50)->comment('Phường/Xã');
            $table->string('district', 50)->comment('Quận/Huyện');
            $table->string('city', 50)->comment('Tỉnh/Thành phố');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
