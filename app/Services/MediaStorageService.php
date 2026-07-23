<?php

namespace App\Services;

use App\Interfaces\MediaStorage;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaStorageService implements MediaStorage
{
    public function upload(UploadedFile $file, string $directory, string $filename): string
    {
        if (! $this->usesSupabase()) {
            Storage::disk($this->localDisk($directory))->putFileAs('', $file, $filename);

            return $filename;
        }

        $path = $directory.'/'.$filename;
        $response = $this->request()
            ->withHeaders(['x-upsert' => 'true'])
            ->withBody($file->get(), $file->getMimeType() ?? 'application/octet-stream')
            ->post($this->objectEndpoint($path));

        if (! $response->successful()) {
            throw new RuntimeException('Unable to upload the image to Supabase Storage.');
        }

        return $this->publicUrl($path);
    }

    public function delete(string $storedImage, string $directory): void
    {
        if (! $this->usesSupabase() || ! str_starts_with($storedImage, $this->publicUrl(''))) {
            Storage::disk($this->localDisk($directory))->delete($storedImage);

            return;
        }

        $path = ltrim(str_replace($this->publicUrl(''), '', $storedImage), '/');
        $response = $this->request()->delete($this->objectEndpoint($path));

        if (! $response->successful() && $response->status() !== 404) {
            throw new RuntimeException('Unable to delete the image from Supabase Storage.');
        }
    }

    private function usesSupabase(): bool
    {
        return filled(config('services.supabase.url'))
            && filled(config('services.supabase.secret_key'))
            && filled(config('services.supabase.storage_bucket'));
    }

    private function request(): PendingRequest
    {
        $key = config('services.supabase.secret_key');

        $headers = ['apikey' => $key];

        if (! str_starts_with($key, 'sb_secret_')) {
            $headers['Authorization'] = 'Bearer '.$key;
        }

        return Http::acceptJson()->withHeaders($headers);
    }

    private function objectEndpoint(string $path): string
    {
        return rtrim(config('services.supabase.url'), '/').'/storage/v1/object/'
            .rawurlencode(config('services.supabase.storage_bucket')).'/'.$this->encodePath($path);
    }

    private function publicUrl(string $path): string
    {
        return rtrim(config('services.supabase.url'), '/').'/storage/v1/object/public/'
            .rawurlencode(config('services.supabase.storage_bucket')).'/'.$this->encodePath($path);
    }

    private function encodePath(string $path): string
    {
        return implode('/', array_map(rawurlencode(...), explode('/', $path)));
    }

    private function localDisk(string $directory): string
    {
        return match ($directory) {
            'plants' => 'publicPlants',
            'guides' => 'publicGuides',
            default => throw new RuntimeException('Unsupported media directory.'),
        };
    }
}
