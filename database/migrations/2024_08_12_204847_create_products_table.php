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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort')->default("1");
            $table->string('model');
            $table->float('price', 8, 2);
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->smallInteger('points')->default("0");
            $table->enum('status', ['enabled', 'disabled']);
            $table->tinyInteger('trending')->default("0");
            $table->smallInteger('subtract')->default("0");
            $table->mediumInteger('quantity');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('short_url');
            $table->smallInteger('min_quantity')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
