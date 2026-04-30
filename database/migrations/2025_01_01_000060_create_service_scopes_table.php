<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_scopes', function (Blueprint $table) {
            $table->id();
            $table->string('scope_type');
            $table->unsignedBigInteger('scope_id');
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
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

            $table->unique(['scope_type', 'scope_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_scopes');
    }
};
