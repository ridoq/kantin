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

    public function upload(string $disk, UploadedFile $file, bool $originalName = true)
    {
        if (!$this->exists($disk)) Storage::makeDirectory($disk);
        if ($originalName) {
            $nama_file = $file->getClientOriginalName();
            $nama_file_counter = 2;
            $nama_file = Str::slug(pathinfo($nama_file, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            while (file_exists(storage_path('app/public/gambar/' . $nama_file))) {
                $nama_file =  $nama_file_counter . "_" . Str::slug(pathinfo($nama_file, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $nama_file_counter++;
            }
            $nama_file_counter++;
            return $file->storeAs($disk, $nama_file);
        }
        return Storage::put($disk, $file);
    }
}
