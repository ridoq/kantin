<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{


    public function upload(string $disk, UploadedFile $file, bool $originalName = true)
        {
            if($originalName){
                return $file->storeAs($disk,$file->getClientOriginalName());
            }
            return Storage::put('public/'.$disk, $file);
        }
}
