<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{

    public function exists(string $file): bool
    {
        return Storage::disk('public')->exists($file);
    }

    public function upload(string $disk, UploadedFile $file, bool $originalName = false)
    {
        if (!$this->exists($disk)) Storage::makeDirectory($disk);
        if ($originalName) {
            $nama_file = $file->getClientOriginalName();
            $nama_file = Str::slug(pathinfo($nama_file, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            return $file->storeAs($disk, $nama_file);
        }
        return Storage::put($disk, $file);
    }
}
