<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    private array $seededPaths = [];

    public function up(): void
    {
        $sourceDir = public_path('images/startbanners');

        if (! File::isDirectory($sourceDir)) {
            return;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        $files = collect(File::files($sourceDir))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), $allowedExtensions))
            ->sortBy(fn ($file) => $file->getFilename());

        if ($files->isEmpty()) {
            return;
        }

        Storage::disk('public')->makeDirectory('banners');

        $sortOrder = DB::table('banners')->max('sort_order') ?? 0;

        foreach ($files as $file) {
            $targetPath = 'banners/' . $file->getFilename();

            Storage::disk('public')->put(
                $targetPath,
                File::get($file->getPathname())
            );

            DB::table('banners')->insert([
                'image_path' => $targetPath,
                'sort_order' => ++$sortOrder,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $sourceDir = public_path('images/startbanners');

        if (! File::isDirectory($sourceDir)) {
            return;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        $filenames = collect(File::files($sourceDir))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), $allowedExtensions))
            ->map(fn ($file) => 'banners/' . $file->getFilename());

        foreach ($filenames as $path) {
            DB::table('banners')->where('image_path', $path)->delete();
            Storage::disk('public')->delete($path);
        }
    }
};
