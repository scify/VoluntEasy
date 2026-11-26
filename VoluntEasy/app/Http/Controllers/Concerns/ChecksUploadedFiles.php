<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;

/**
 * Checks the files of a volunteer or collaboration form before they are saved.
 */
trait ChecksUploadedFiles
{
    /** Largest file that users can upload, in bytes (10 MB). */
    private int $maxUploadBytes = 10_000_000;

    /**
     * The uploaded "files[]" of the request. The form always sends the
     * field; empty slots are null, so they are removed.
     *
     * @return array<int, UploadedFile>
     */
    protected function uploadedFiles(): array
    {
        return array_filter((array) request()->file('files'));
    }

    /**
     * Return a redirect back with a message if a file already exists in the
     * uploads folder or is too large; return null if all files are acceptable.
     *
     * @param  array<int, UploadedFile>  $files
     * @param  string  $folder  Folder under public/assets/uploads
     * @param  string  $langFile  Translation file with the "alreadyExists" and "moreThan10mb" messages
     */
    protected function rejectUploads(array $files, string $folder, string $langFile): ?RedirectResponse
    {
        foreach ($files as $file) {
            $name = $file->getClientOriginalName();

            $problem = match (true) {
                file_exists(public_path("assets/uploads/{$folder}/{$name}")) => 'alreadyExists',
                $file->getSize() > $this->maxUploadBytes => 'moreThan10mb',
                default => null,
            };

            if ($problem !== null) {
                session()->flash('flash_message', trans("{$langFile}.{$problem}", ['filename' => $name]));
                session()->flash('flash_type', 'alert-danger');

                return redirect()->back()->withInput();
            }
        }

        return null;
    }
}
