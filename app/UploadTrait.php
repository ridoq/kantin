<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{

    public function exists(string $file) : bool
    {
        return Storage::disk('public')->exists($file);
    }

    public function upload(string $disk, UploadedFile $file, bool $originalName = true)
        {
            if(!$this->exists($disk))Storage::makeDirectory($disk);
            if(!$originalName){
                return $file->storeAs($disk,$file->getClientOriginalName());
            }
            return Storage::put($disk, $file);
        }
}
