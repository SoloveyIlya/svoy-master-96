<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_run_id')->constrained('import_runs')->cascadeOnDelete();
            $table->string('url');
            $table->string('type');
            $table->string('status')->default('new');
            $table->dateTime('last_fetched_at')->nullable();
            $table->string('content_hash')->nullable();
            $table->integer('http_code')->nullable();
            $table->text('error_text')->nullable();
            $table->string('raw_path')->nullable();
            $table->timestamps();

            $table->unique(['import_run_id', 'url']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_urls');
    }
};
