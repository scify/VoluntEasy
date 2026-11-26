<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Saves the files that users upload for volunteers and collaborations.
 *
 * The files go to a public folder, so files that a web server can execute
 * or that a browser runs as a page are refused.
 */
class FileService
{
    /** @var list<string> */
    private const BLOCKED_EXTENSIONS = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar', 'pht', 'phps',
        'cgi', 'pl', 'py', 'sh', 'asp', 'aspx', 'jsp', 'exe',
        'html', 'htm', 'shtml', 'xhtml', 'svg', 'js', 'htaccess',
    ];

    public function storeFile(UploadedFile $file, string $fileName, string $path): string
    {
        $fileName = basename($fileName);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileName === '' || str_starts_with($fileName, '.') || in_array($extension, self::BLOCKED_EXTENSIONS, true)) {
            throw ValidationException::withMessages([
                'files' => trans('validation.mimes', ['attribute' => $fileName, 'values' => 'pdf, doc, docx, odt, jpg, png']),
            ]);
        }

        $file->move($path, $fileName);

        return $fileName;
    }
}
