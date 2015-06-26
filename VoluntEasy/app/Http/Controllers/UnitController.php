<?php namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest as UnitRequest;
use App\Models\Step;
use App\Models\Unit as Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $units = Unit::orderBy('description', 'ASC')->paginate(3);

        return view("main.units.list", compact('units'));
    }

    /**
     * Get the tree with its branches in JSON format
     *
     * @return mixed
     */
    public function tree($id)
    {
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
    public function create()
    {
        $root = UnitService::getRoot();

        if (count($root) == 0) {
            $type = 'root';
            return view("main.units.create_root", compact('type'));
        } else {
            $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();
            $type = 'branch';
            return view("main.units.create_branch", compact('type', 'tree'));
        }
    }


    /**
     * Store a newly created resource in storage.
     * Also assign the predefined steps.
     *
     * @param UnitRequest $request
     * @return Response
     */
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->all());

        $unit->steps()->saveMany($this->createSteps());

        return Redirect::to('main/units');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $active = Unit::findOrFail($id);
        $active->load('actions', 'volunteers');

        $tree = UnitService::getTree();

        $type = UnitService::type($active);


        $volunteers = Volunteer::all();

        //if the request comes from ajax, return only a section of the needed code
        /* if (Request::ajax()) {
             $view = View::make('main.units.show')->with('active', $active);
             return $view->renderSections()['details'];
         }
         */

        return view("main.units.show", compact('active', 'tree', 'type', 'volunteers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $active = Unit::where('id', $id)->with('users', 'actions')->first();

        //display all the users in the front end
        $users = User::all();

        $userIds = UnitService::userIds($active);

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
    public function update(UnitRequest $request)
    {
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
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        $unit->delete();

        return Redirect::to('main/units');
    }


    public function wholeTree()
    {
        $tree = UnitService::getTree();

        return view("main.units.tree", compact('tree'));
    }

    public function addUsers(Request $request)
    {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->users()->sync($request->get('users'));

        return $unit->id;
    }

    public function addVolunteers(Request $request)
    {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->volunteers()->sync($request->get('volunteers'));

        return $unit->id;
    }


    /**
     * When creating a new unit, automatically assign some predefined steps
     *
     * @return array
     */
    public function createSteps()
    {
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

}
