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

    /**
     * Handle multiple gallery images upload (up to maxImages).
     *
     * @param Request $request
     * @param string $folder Subfolder within public/images/
     * @param array $existingImages Currently stored image paths
     * @param string $inputName Form input name for array of files
     * @param string $retainedInputName Form input name for array of existing image paths to keep
     * @param int $maxImages Maximum allowed images (default 10)
     * @return array Array of relative image paths
     */
    protected function handleMultipleImagesUpload(
        Request $request,
        string $folder,
        array $existingImages = [],
        string $inputName = 'gallery_images',
        string $retainedInputName = 'retained_gallery_images',
        int $maxImages = 10
    ): array {
        $safeFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder);
        $destinationPath = public_path("images/{$safeFolder}");

        // If the user submitted a list of existing images to retain, keep only those
        $finalGallery = [];
        if ($request->has($retainedInputName) && is_array($request->input($retainedInputName))) {
            $retained = $request->input($retainedInputName);
            foreach ($existingImages as $existing) {
                if (in_array($existing, $retained, true)) {
                    $finalGallery[] = $existing;
                } else {
                    // Clean up removed image if stored locally in this folder
                    if (Str::startsWith($existing, "images/{$safeFolder}/")) {
                        $oldFile = public_path($existing);
                        if (File::exists($oldFile)) {
                            File::delete($oldFile);
                        }
                    }
                }
            }
        } else {
            // Default: preserve existing images unless explicitly overridden
            $finalGallery = $existingImages;
        }

        // Process newly uploaded files
        if ($request->hasFile($inputName)) {
            $files = $request->file($inputName);
            if (!is_array($files)) {
                $files = [$files];
            }

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($files as $file) {
                if (count($finalGallery) >= $maxImages) {
                    break; // Cap at maxImages
                }

                if ($file && $file->isValid()) {
                    $extension = strtolower($file->getClientOriginalExtension());
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $extension = 'jpg';
                    }
                    $filename = $safeFolder . '_gal_' . time() . '_' . Str::random(10) . '.' . $extension;
                    $file->move($destinationPath, $filename);
                    $finalGallery[] = "images/{$safeFolder}/{$filename}";
                }
            }
        }

        return array_slice($finalGallery, 0, $maxImages);
    }
}
