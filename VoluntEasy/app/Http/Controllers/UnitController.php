<?php namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest as UnitRequest;
use App\Models\Step;
use App\Models\Unit as Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class UnitController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permissions.unit', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $units = Unit::orderBy('description', 'ASC')->with('parent')->paginate(5);
        $units->setPath(\URL::to('/') . '/units');

        $userUnits = UserService::userUnits();

        return view("main.units.list", compact('units', 'userUnits'));
    }

    /**
     * Get the tree with its branches in JSON format
     *
     * @return mixed
     */
    public function tree($id) {
        $unit = Unit::where('id', $id)->with('allChildren')->first();

        return $unit;
    }

    /**
     * Show the form for creating a new resource.
     * Roots and branches have a different layout, so we use
     * different routes and templates for them.
     *
     * @return Response
     */
    public function create() {
        $root = UnitService::getRoot();

        $userUnits = UserService::userUnits();

        $users = User::all();

        if (count($root) == 0) {
            $type = 'root';
            return view("main.units.create_root", compact('type', 'users'));
        } else {
            $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();
            $type = 'branch';

            return view("main.units.create_branch", compact('tree', 'type', 'users', 'userUnits'));
            // return view("main.units.create_branch", compact('type', 'tree', 'userUnits'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * Also assign the predefined steps and
     * the users, if they are set.
     *
     * @param UnitRequest $request
     * @return Response
     */
    public function store(UnitRequest $request) {
        $unit = Unit::create($request->all());

        $inputs = $request->all();

        $users = [];

        foreach ($inputs as $id => $input) {
            if (preg_match('/user.*/', $id)) {
               array_push($users, $input);
            }
        }

        $unit->users()->sync($users);

        $unit->steps()->saveMany($this->createSteps());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $active = Unit::findOrFail($id);

        $active->load('actions', 'volunteers');

        $tree = UnitService::getTree();

        $type = UnitService::type($active);

        $userUnits = UserService::userUnits();

        $volunteers = Volunteer::all();

        $volunteerIds = VolunteerService::volunteerIds($active->volunteers);


        //if the request comes from ajax, return only a section of the needed code
        /* if (Request::ajax()) {
             $view = View::make('main.units.show')->with('active', $active);
             return $view->renderSections()['details'];
         }
         */

        return view("main.units.show", compact('active', 'tree', 'type', 'volunteers', 'userUnits', 'volunteerIds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $active = Unit::where('id', $id)->with('users', 'actions')->first();

        //display all the users in the front end
        $users = User::all();

        $userIds = UserService::userIds($active->users);

        $tree = UnitService::getTree();

        $type = UnitService::type($active);

        return view("main.units.edit", compact('active', 'tree', 'type', 'users', 'userIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnitRequest $request
     * @return Response
     */
    public function update(UnitRequest $request) {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->update($request->all());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $unit = Unit::findOrFail($id);
        $unit->load('actions');
        $unit->load('allChildren');
        $unit->load('users');
        $unit->load('volunteers');

        //if the unit has actions, do not delete
        if (sizeof($unit->actions) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει δράσεις και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return Redirect::to('units');
        }
        //if the unit has children units, do not delete
        if (sizeof($unit->allChildren) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα δεν μπορεί να διαγραφεί γιατί εξαρτώνται άλλες μονάδες από αυτή.');
            Session::flash('flash_type', 'alert-danger');

            return Redirect::back();
        }
        //if the unit has volunteers, do not delete
        if (sizeof($unit->volunteers) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return Redirect::back();
        }
        //if the unit has users, do not delete
        if (sizeof($unit->users) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει χρήστες και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return Redirect::back();
        }

        $unit->steps()->delete();
        $unit->delete();

        return Redirect::back();
    }

    /**
     * Search all units
     *
     * @return mixed
     */
    public function search() {
        $userUnits = UserService::userUnits();
        $units = UnitService::search();

        $view = View::make('main.units.list')->with('units', $units)->with('userUnits', $userUnits);
        return $view->renderSections()['table'];
    }

    public function rootUnit() {
        return view('auth/rootUnit');
    }

    public function wholeTree() {
        $tree = UnitService::getTree();
        $userUnits = UserService::userUnits();
        return view("main.tree.tree", compact('tree', 'userUnits'));
    }

    /**
     * Sync the users with the db.
     *
     * @param Request $request
     * @return mixed
     */
    public function addUsers(Request $request) {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->users()->sync($request->get('users'));

        return $unit->id;
    }

    /**
     * Sync the unit volunteers with the db.
     *
     * @param Request $request
     * @return mixed
     */
    public function addVolunteers(Request $request) {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->volunteers()->sync($request->get('volunteers'));

        return $unit->id;
    }

    /**
     * When creating a new unit, automatically assign some predefined steps
     *
     * @return array
     */
    public function createSteps() {
        $steps = [
            new Step([
                'description' => 'Επικοινωνία με εθελοντή',
                'step_order' => 1
            ]),
            new Step([
                'description' => 'Συνέντευξη με εθελοντή',
                'step_order' => 2
            ]),
            new Step([
                'description' => 'Ανάθεση σε Μονάδα/Δράση',
                'step_order' => 3
            ])
        ];

        return $steps;
    }


    public $branch = [];
    public function branch ($id){

        $unit = Unit::where('id', $id)->with('allParents')->first();

        return $unit;

        /*if($unit->parent_unit_id!=null){
            array_push($branch, $unit->id);

        }*/

    }
}
