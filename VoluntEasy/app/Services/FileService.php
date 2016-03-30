<?php namespace App\Services;

/**
 * Class FileService
 * @package App\Services
 *
 * This service is responsible for saving files.
 *
 */
class FileService {

    public function storeFile($file, $fileName, $path) {

        $file->move($path, $fileName); // uploading file to given path

        return $fileName;
    }

    public function storeFiles($file, $path) {

    }


}
