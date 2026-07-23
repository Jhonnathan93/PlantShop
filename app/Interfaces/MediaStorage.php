<?php

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;

interface MediaStorage
{
    public function upload(UploadedFile $file, string $directory, string $filename): string;

    public function delete(string $storedImage, string $directory): void;
}
