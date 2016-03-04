<?php namespace App\Http\Controllers;


use App\Http\Requests\CTAVolunteerRequest;
use App\Models\Action;
use App\Models\CTA\CTADate;
use App\Models\CTA\CTAVolunteer;
use App\Models\CTA\PublicAction;
use App\Models\CTA\PublicActionSubTask;
use App\Models\Volunteer;
use App\Services\Facades\UserService;

/**
 * CTAContoller is responsible for the public cta page actions
 *
 * Class CTAController
 * @package App\Http\Controllers
 */
class CTAController extends Controller {


    public function __construct() {
        $this->middleware('auth', ['except' => ['cta']]);
    }


    public function cta() {

        $action = Action::find(1);

        return view('main.cta.cta', compact('action'));
    }

    public function participate($id) {

        $publicAction = PublicAction::where('public_url', $id)->with('subtasks.subtask.workDates', 'subtasks.subtask.task')->first();
        $tasks = [];

        //just transform data to the correct form
        foreach ($publicAction->subtasks as $subtask) {
            $task = $subtask->subtask->task;
            $ctaSubtasks = [];
            unset($subtask->subtask->task);

            if (sizeof($tasks) == 0) {
                $ctaSubtasks = [];
                array_push($ctaSubtasks, $subtask->subtask);
                $task->ctaSubtasks = $ctaSubtasks;
                array_push($tasks, $task);
            } else {

                foreach ($tasks as $t) {
                    if ($t->id == $task->id) {
                        array_push($ctaSubtasks, $subtask->subtask);
                        $task->ctaSubtasks = $ctaSubtasks;
                    } else {
                        $ctaSubtasks = [];
                        $task->ctaSubtasks = $ctaSubtasks;
                        array_push($tasks, $task);
                    }
                }
            }
        }

        $publicAction->tasks = $tasks;
        return $publicAction;

        if ($publicAction != null && $publicAction->isActive) {
            $publicAction->tasks = $tasks;
            $action = $publicAction->load('action')->action;
            return view('main.cta.participate', compact('action', 'publicAction', 'tasks'));
        } else {
            return view('main.cta.participate');
        }
    }

    public function store() {

        $publicAction = new PublicAction([
            'description' => \Request::get('public_description'),
            'address' => \Request::get('public_address'),
            'map_url' => \Request::get('public_map_url'),
            'executive_name' => \Request::get('public_exec_name'),
            'executive_email' => \Request::get('public_exec_email'),
            'executive_phone' => \Request::get('public_exec_phone'),
            'public_url' => \Request::get('actionId') . '-' . \Request::get('actionName'),
            'isActive' => true,
            'action_id' => \Request::get('actionId')
        ]);

        $publicAction->save();

        if (\Request::has('subtasks'))
            $this->savePublicSubtasks($publicAction);

        return $publicAction;
    }

    public function update() {
        $publicAction = PublicAction::find(\Request::get('publicActionId'));

        $publicAction->update([
            'description' => \Request::get('public_description'),
            'address' => \Request::get('public_address'),
            'map_url' => \Request::get('public_map_url'),
            'executive_name' => \Request::get('public_exec_name'),
            'executive_email' => \Request::get('public_exec_email'),
            'executive_phone' => \Request::get('public_exec_phone'),
            'public_url' => \Request::get('actionId') . '-' . \Request::get('actionName'),
            'isActive' => true,
            'action_id' => \Request::get('actionId')
        ]);

        return $this->savePublicSubtasks($publicAction);

        return $publicAction;
    }

    /**
     * Save the volunteer info
     *
     * @param CTAVolunteerRequest $request
     * @return mixed
     */
    public function volunteerInterested(CTAVolunteerRequest $request) {

        $isVolunteer = 0;
        $volunteer = Volunteer::where('email', $request['email'])->first();
        if ($volunteer != null)
            $isVolunteer = 1;

        $ctaVolunteer = new CTAVolunteer([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'comments' => $request['comments'],
            'public_action_id' => $request['publicActionId'],
            'isVolunteer' => $isVolunteer,
        ]);

        $ctaVolunteer->save();

        //save the dates that the volunteer is interested for
        if (isset($request['dates'])) {
            foreach ($request['dates'] as $id => $date) {
                $date = new CTADate([
                    'cta_volunteers_id' => $ctaVolunteer->id,
                    'subtask_work_dates_id' => $id,
                ]);

                $date->save();
            }
        }

        //get all the data needed to display the tasks that the volunteers
        //is interested for
        $ctaVolunteer->load('dates.date.subtask.task');
        $publicAction = PublicAction::with('action')->find($request['publicActionId']);
        $admins = UserService::getAdmins();

        //send email to all admins
        foreach ($admins as $admin) {

            \Mail::send('app_emails.cta_new_volunteer', ['user' => $admin, 'ctaVolunteer' => $ctaVolunteer, 'volunteer' => $volunteer, 'publicAction' => $publicAction], function ($message) use ($admin) {
                $message->to($admin->email, $admin->name)->subject('[VoluntEasy] Εκδήλωση ενδιαφέροντος από εθελοντή');
            });
        }

        return view('main.cta.thankyou');
    }

    /**
     * Save the subtasks that will be displayed on the public page
     */
    private function savePublicSubtasks($publicAction) {
        $publicSubtasksIds = [];
        foreach (\Request::get('subtasks') as $i => $subtask) {

            if (isset($subtask['name']) && $subtask['name'] == 'on') {
                //check if the relationship already exists
                $publicSubtask = PublicActionSubTask::where('public_actions_id', $publicAction->id)->where('subtask_id', $i)->first();

                //if not, create a new publicActionSubtask
                if ($publicSubtask == null) {
                    $publicSubtask = new PublicActionSubTask([
                        'public_actions_id' => $publicAction->id,
                        'subtask_id' => $i,
                        'description' => $subtask['comments'],
                    ]);

                    $publicSubtask->save();
                } else {
                    //else update the current one
                    $publicSubtask->update([
                        'description' => $subtask['comments'],
                    ]);
                }
                array_push($publicSubtasksIds, $publicSubtask->id);
            }
        }

        PublicActionSubTask::where('public_actions_id', $publicAction->id)->whereNotIn('id', $publicSubtasksIds)->delete();

        return PublicActionSubTask::where('public_actions_id', $publicAction->id)->whereNotIn('id', $publicSubtasksIds)->get();

        return;
    }
}
