<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignId('model_id')->constrained('device_models')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('status')->default('active');

            $table->text('custom_intro')->nullable();
            $table->text('custom_body')->nullable();
            $table->json('custom_faq_json')->nullable();

            $table->string('price_from')->nullable();
            $table->string('duration_text')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_h1')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('noindex')->default(false);

            $table->timestamps();

            $table->unique(['model_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
