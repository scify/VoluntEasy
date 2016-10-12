<?php namespace App\Services;

use App\Models\Collaboration;
use App\Models\CollaborationFile;
use App\Services\Facades\FileService as FileServiceFacade;
use App\Services\Facades\SearchService as Search;


class CollaborationService{

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    private $filters = [
        'start_date' => '>',
        'end_date' => '<',
        'active_only' => '',
        'name' => '=',
        'type' => '=',
    ];

    /**
     * Store the files uploaded for the collaboration
     *
     * @param $files
     * @param $id
     * @return boolean
     */
    public function storeFiles($files, $id) {

        foreach ($files as $file) {
            if ($file != null) {
                $destinationPath = public_path() . '/assets/uploads/collaborations';
                $fileName = $file->getClientOriginalName();

                //check if file already exists
                if (file_exists($destinationPath . '/' . $fileName)) {
                    return false;
                } else {

                    $filename = FileServiceFacade::storeFile($file, $fileName, $destinationPath);

                    //create a row to the db to associate the file with the volunteer
                    $dbFile = new CollaborationFile([
                        'filename' => $filename,
                        'collaboration_id' => $id
                    ]);
                    $dbFile->save();
                }
            }
        }
    }




    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = Collaboration::select();

        //dd(\Input::all());

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column)) {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::noDropDown($value, $column))
                            $query->where($column, '=', $value);
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value . '%');
                        break;
                    case '>':
                        //operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date("Y-m-d", strtotime($value));
                        $query->where($column, '>', $value);
                        break;
                    case '<':
                        //operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date("Y-m-d", strtotime($value));
                        $query->where($column, '<', $value);
                        break;
                    case '':
                        switch ($column) {
                            case 'active_only':
                                $now = date('Y-m-d');
                                $query->where('end_date', '>=', $now);
                                break;
                        }
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('name', 'ASC')->get();

        $data = $result;

        return ["data" => $data];
    }

}
