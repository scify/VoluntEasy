<?php namespace App\Http\Controllers;

use App\Http\Requests\CollaborationRequest;
use App\Models\ActionVolunteerHistory;
use App\Models\Collaboration;
use App\Models\CollaborationFile;
use App\Models\Descriptions\CollaborationType;
use App\Models\Executive;
use App\Services\Facades\CollaborationService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CollaborationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $collaborations = Collaboration::all();

        return view("main.collaborations.list", compact('collaborations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $collaborationTypes = CollaborationType::all()->lists('description', 'id')->all();
        $collaborationTypes[0] = trans('entities/search.choose');
        ksort($collaborationTypes);

        return view('main.collaborations.create', compact('collaborationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CollaborationRequest $request
     * @return Response
     */
    public function store(CollaborationRequest $request) {

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);
        $collaboration = Collaboration::create($request->only('start_date', 'end_date', 'name', 'type_id', 'phone', 'address', 'comments'));

        //create the executive obj
        if ($request['execName'] || $request['address'] || $request['phone'] || $request['email']) {
            $executive = Executive::create([
                'name' => $request['execName'],
                'address' => $request['execAddress'],
                'phone' => $request['execPhone'],
                'email' => $request['execEmail']]);

            //assign to the collaboration
            $collaboration->executives()->save($executive);
        }


        //check if files uploaded already exist
        $files = \Input::file('files');
        $flag = false;

        foreach ($files as $file) {
            if ($file != null) {
                $flag = true;
                $filename = public_path() . '/assets/uploads/collaborations/' . $file->getClientOriginalName();

                //if file already exists, redirect back with error message
                if (file_exists($filename)) {
                    \Session::flash('flash_message', trans('entities/collaborations.alreadyExists', ['filename' => $file->getClientOriginalName()]));
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back()->withInput();
                }
                //if file exceeds maximum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    \Session::flash('flash_message', trans('entities/collaborations.moreThan10mb', ['filename' => $file->getClientOriginalName()]));
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back()->withInput();
                }
            }
        }

        if ($files != null && sizeof($files) > 0 && $flag == true)
            CollaborationService::storeFiles($files, $collaboration->id);

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $collaboration = Collaboration::with('executives', 'files', 'type')->findOrFail($id);

        //check if collaboration has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $collaboration->end_date))->format('Y-m-d');
        $collaboration->expired = false;
        if ($endDate < $now)
            $collaboration->expired = true;

        return view('main.collaborations.show', compact('collaboration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $collaborationTypes = CollaborationType::all()->lists('description', 'id')->all();
        $collaborationTypes[0] = trans('entities/search.choose');
        ksort($collaborationTypes);

        $collaboration = Collaboration::with('executives', 'files')->findOrFail($id);

        return view('main.collaborations.edit', compact('collaboration', 'collaborationTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CollaborationRequest $request
     * @return Response
     */
    public function update(CollaborationRequest $request) {
        $collaboration = Collaboration::findOrFail($request->get('id'));

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);

        $collaboration->update($request->only('start_date', 'end_date', 'name', 'type_id', 'phone', 'address', 'comments'));

        //update the executive obj
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

        //check if files uploaded already exist
        $files = \Input::file('files');
        $flag = false;

        foreach ($files as $file) {
            if ($file != null) {
                $flag = true;
                $filename = public_path() . '/assets/uploads/collaborations/' . $file->getClientOriginalName();

                //if file already exists, redirect back with error message
                if (file_exists($filename)) {
                    \Session::flash('flash_message', trans('entities/collaborations.alreadyExists', ['filename' => $file->getClientOriginalName()]));
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }

                //if file exceeds maximum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    \Session::flash('flash_message', trans('entities/collaborations.moreThan10mb', ['filename' => $file->getClientOriginalName()]));
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }
            }
        }

        if ($files != null && sizeof($files) > 0 && $flag == true)
            CollaborationService::storeFiles(\Input::file('files'), $collaboration->id);

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $collaboration = Collaboration::findOrFail($id);
        $collaboration->load('files');


        foreach ($collaboration->files as $f) {
            $file = CollaborationFile::find($f->id);

            $filename = public_path() . '/assets/uploads/collaborations/' . $file->filename;

            //if the file exists, delete it from the filesystem
            if (file_exists($filename))
                unlink($filename);

            //delete the row from the db
            $file->delete();
        }

        $collaboration->delete();

        Session::flash('flash_message', trans('entities/collaborations.deleted'));
        Session::flash('flash_type', 'alert-success');


        return;
    }

    /**
     * Search all actions
     *
     * @return mixed
     */
    public function search() {
        $collaborations = CollaborationService::search();

        return $collaborations;
    }


    /**
     * Delete a collaboration's file from db and from filesystem
     *
     * @return mixed
     */
    public function deleteFile() {
        $id = \Request::get('id');
        $file = CollaborationFile::find($id);

        $filename = public_path() . '/assets/uploads/collaborations/' . $file->filename;

        //if the file exists, delete it from the filesystem
        if (file_exists($filename))
            unlink($filename);

        //delete the row from the db
        $file->delete();

        return $filename;
    }


}
