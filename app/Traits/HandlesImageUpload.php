<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
    /**
     * Handle image upload from computer (or fallback URL).
     *
     * @param Request $request
     * @param string $folder Subfolder within public/images/ (e.g. 'resorts', 'accommodations')
     * @param string|null $currentPath Existing image_url from database (for cleanup on replacement)
     * @param string $inputName Form input name for the uploaded file (default 'image')
     * @param string $urlInputName Form input name for fallback URL (default 'image_url')
     * @return string|null Relative image path (e.g. 'images/resorts/...') or URL
     */
    protected function handleImageUpload(
        Request $request,
        string $folder,
        ?string $currentPath = null,
        string $inputName = 'image',
        string $urlInputName = 'image_url'
    ): ?string {
        if ($request->hasFile($inputName)) {
            $imageFile = $request->file($inputName);

            // Generate a safe, sanitized filename with unique timestamp and random string
            $extension = strtolower($imageFile->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $extension = 'jpg';
            }
            $safeFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder);
            $filename = $safeFolder . '_' . time() . '_' . Str::random(10) . '.' . $extension;

            $destinationPath = public_path("images/{$safeFolder}");
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $imageFile->move($destinationPath, $filename);

            // If an old local image was previously saved in this folder, clean it up
            if ($currentPath && Str::startsWith($currentPath, "images/{$safeFolder}/")) {
                $oldFile = public_path($currentPath);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            return "images/{$safeFolder}/{$filename}";
        }

        // Fall back to image_url input if provided, otherwise preserve current path
        if ($request->filled($urlInputName)) {
            return $request->input($urlInputName);
        }

        return $currentPath;
    }
}
