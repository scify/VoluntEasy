<?php

namespace App\Services;

use App\Models\Collaboration;
use App\Models\CollaborationFile;
use App\Models\Descriptions\CollaborationType;

class CollaborationService
{
    private FileService $fileService;

    private SearchService $searchService;

    public function __construct(FileService $fileService, SearchService $searchService)
    {
        $this->fileService = $fileService;
        $this->searchService = $searchService;
    }

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     *
     * @var array
     */
    private $filters = [
        'start_date' => '>',
        'end_date' => '<',
        'active_only' => '',
        'name' => '=',
        'type' => 'type',
    ];

    /**
     * Store the files uploaded for the collaboration
     *
     * @return bool
     */
    public function storeFiles($files, $id)
    {

        foreach ($files as $file) {
            if ($file != null) {
                $destinationPath = public_path().'/assets/uploads/collaborations';
                $fileName = $file->getClientOriginalName();

                // check if file already exists
                if (file_exists($destinationPath.'/'.$fileName)) {
                    return false;
                } else {

                    $filename = $this->fileService->storeFile($file, $fileName, $destinationPath);

                    // create a row to the db to associate the file with the volunteer
                    $dbFile = new CollaborationFile([
                        'filename' => $filename,
                        'collaboration_id' => $id,
                    ]);
                    $dbFile->save();
                }
            }
        }

        return true;
    }

    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search()
    {

        $query = Collaboration::select();

        // dd(\Request::all());

        foreach ($this->filters as $column => $filter) {
            if (\Request::filled($column)) {
                $value = \Request::get($column);
                switch ($filter) {
                    case '=':
                        if (! $this->searchService->notDropDown($value, $column)) {
                            $query->where($column, '=', $value);
                        }
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value.'%');
                        break;
                    case '>':
                        // operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date('Y-m-d', strtotime($value));
                        $query->where($column, '>', $value);
                        break;
                    case '<':
                        // operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date('Y-m-d', strtotime($value));
                        $query->where($column, '<', $value);
                        break;
                    case 'type':
                        // the user types the (translated) name of the type
                        $query->whereIn('type_id', CollaborationType::matching((string) $value)->pluck('id')->all());
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

        $result = $query->orderBy('name', 'asc')->get();

        $data = $result;

        return ['data' => $data];
    }
}
