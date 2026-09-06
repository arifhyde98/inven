<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * Store an uploaded image in public/assets/images/{subfolder}
     *
     * @param UploadedFile $file
     * @param string $subfolder
     * @param string|null $oldFileName
     * @return string generated filename
     */
    public function uploadImage(UploadedFile $file, string $subfolder = 'profiles', ?string $oldFileName = 'default.png'): string
    {
        $destinationPath = public_path("assets/images/{$subfolder}");
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $extension = $file->getClientOriginalExtension();
        $filename = md5(uniqid(rand(), true)) . '.' . $extension;

        $file->move($destinationPath, $filename);

        // Remove old file if not default
        if ($oldFileName && $oldFileName !== 'default.png') {
            $oldPath = public_path("assets/images/{$subfolder}/{$oldFileName}");
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        return $filename;
    }
}
