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


    /**
     * Check if files exist or exceed maximum allowed size
     *
     * @param $files
     * @return mixed
     */
    /*
    public function validate($files) {
        $flag = false;

        foreach ($files as $file) {
            if ($file != null) {
                $filename = public_path() . '/assets/uploads/volunteers/' . $file->getClientOriginalName();

                //if file already exists, redirect back with error message
                if (file_exists($filename)) {
                    return 'file exists';
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' υπάρχει ήδη.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back()->withInput();
                }
                //if file exceeds mazimum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    return 'file too big';
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' ξεπερνά σε μέγεθος τα 10mb.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back()->withInput();
                }
            }
        }
        return 'ok';
    }
    */

}
