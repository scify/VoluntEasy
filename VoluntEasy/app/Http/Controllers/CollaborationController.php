<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ChecksUploadedFiles;
use App\Http\Requests\CollaborationRequest;
use App\Models\Collaboration;
use App\Models\CollaborationFile;
use App\Models\Descriptions\CollaborationType;
use App\Models\Executive;
use App\Services\CollaborationService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CollaborationController extends Controller
{
    private CollaborationService $collaborationService;

    use ChecksUploadedFiles;

    public function __construct(CollaborationService $collaborationService)
    {
        $this->collaborationService = $collaborationService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaborations = Collaboration::all();

        return view('main.collaborations.list', compact('collaborations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collaborationTypes = CollaborationType::all()->pluck('description', 'id')->all();
        $collaborationTypes[0] = trans('entities/search.choose');
        ksort($collaborationTypes);

        return view('main.collaborations.create', compact('collaborationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CollaborationRequest $request)
    {

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);
        $collaboration = Collaboration::create($request->only('start_date', 'end_date', 'name', 'type_id', 'phone', 'address', 'comments'));

        // create the executive obj
        if ($request['execName'] || $request['address'] || $request['phone'] || $request['email']) {
            $executive = Executive::create([
                'name' => $request['execName'],
                'address' => $request['execAddress'],
                'phone' => $request['execPhone'],
                'email' => $request['execEmail']]);

            // assign to the collaboration
            $collaboration->executives()->save($executive);
        }

        $files = $this->uploadedFiles();
        if ($rejected = $this->rejectUploads($files, 'collaborations', 'entities/collaborations')) {
            return $rejected;
        }

        if ($files !== []) {
            $this->collaborationService->storeFiles($files, $collaboration->id);
        }

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $collaboration = Collaboration::with('executives', 'files', 'type')->findOrFail($id);

        // check if collaboration has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $collaboration->end_date))->format('Y-m-d');
        $collaboration->expired = false;
        if ($endDate < $now) {
            $collaboration->expired = true;
        }

        return view('main.collaborations.show', compact('collaboration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $collaborationTypes = CollaborationType::all()->pluck('description', 'id')->all();
        $collaborationTypes[0] = trans('entities/search.choose');
        ksort($collaborationTypes);

        $collaboration = Collaboration::with('executives', 'files')->findOrFail($id);

        return view('main.collaborations.edit', compact('collaboration', 'collaborationTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CollaborationRequest $request)
    {
        $collaboration = Collaboration::findOrFail($request->get('id'));

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);

        $collaboration->update($request->only('start_date', 'end_date', 'name', 'type_id', 'phone', 'address', 'comments'));

        // update the executive obj
        if ($request->has('executive_id')) {
            $executive = Executive::find($request['executive_id']);
            if ($executive != null) {
                $executive->name = $request['execName'];
                $executive->address = $request['execAddress'];
                $executive->phone = $request['execPhone'];
                $executive->email = $request['execEmail'];

                $executive->save();
            }
        }

        $files = $this->uploadedFiles();
        if ($rejected = $this->rejectUploads($files, 'collaborations', 'entities/collaborations')) {
            return $rejected;
        }

        if ($files !== []) {
            $this->collaborationService->storeFiles($files, $collaboration->id);
        }

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $collaboration = Collaboration::findOrFail($id);
        $collaboration->load('files');

        foreach ($collaboration->files as $f) {
            $file = CollaborationFile::find($f->id);

            $filename = public_path().'/assets/uploads/collaborations/'.$file->filename;

            // if the file exists, delete it from the filesystem
            if (file_exists($filename)) {
                unlink($filename);
            }

            // delete the row from the db
            $file->delete();
        }

        $collaboration->delete();

        Session::flash('flash_message', trans('entities/collaborations.deleted'));
        Session::flash('flash_type', 'alert-success');

    }

    /**
     * Search all actions
     *
     * @return mixed
     */
    public function search()
    {
        $collaborations = $this->collaborationService->search();

        return $collaborations;
    }

    /**
     * Delete a collaboration's file from db and from filesystem
     *
     * @return mixed
     */
    public function deleteFile()
    {
        $id = \Request::get('id');
        $file = CollaborationFile::find($id);

        $filename = public_path().'/assets/uploads/collaborations/'.$file->filename;

        // if the file exists, delete it from the filesystem
        if (file_exists($filename)) {
            unlink($filename);
        }

        // delete the row from the db
        $file->delete();

        return $filename;
    }
}
