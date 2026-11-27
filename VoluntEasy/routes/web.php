<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\Api\ActionApiController;
use App\Http\Controllers\Api\CollaborationApiController;
use App\Http\Controllers\Api\TreeApiController;
use App\Http\Controllers\Api\UnitApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\VolunteerApiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\CTAController;
use App\Http\Controllers\CTAVolunteerController;
use App\Http\Controllers\EtcController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubtaskChecklistController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\SubtaskShiftController;
use App\Http\Controllers\TaskChecklistController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskShiftController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'mainIndex']);

// //////////////////
// Authentication //
// //////////////////
Route::middleware('guest')->group(function () {
    Route::get('auth/login', [AuthController::class, 'getLogin'])->name('login');
    Route::post('auth/login', [AuthController::class, 'postLogin'])->middleware('throttle:10,1');
    Route::get('password/email', [PasswordController::class, 'getEmail']);
    Route::post('password/email', [PasswordController::class, 'postEmail'])->middleware('throttle:5,1');
    Route::get('password/reset/{token}', [PasswordController::class, 'getReset'])->name('password.reset');
    Route::post('password/reset', [PasswordController::class, 'postReset']);
});
Route::get('auth/logout', [AuthController::class, 'getLogout'])->middleware('auth');

Route::get('landing', [WelcomeController::class, 'index']);

// //////////////
// User Routes //
// //////////////
Route::get('users', [UserController::class, 'index']);
Route::get('users/one/{id}', [UserController::class, 'show'])->name('user/profile');
Route::get('users/create', [UserController::class, 'create']);
Route::get('users/edit/{id}', [UserController::class, 'edit']);
Route::post('users/delete/{id}', [UserController::class, 'destroy']);
Route::post('users/update', [UserController::class, 'update']);
Route::post('users/store', [UserController::class, 'store']);
Route::post('users/units', [UserController::class, 'addUnits']);
Route::post('users/search', [UserController::class, 'search']);

// //////////////
// Unit Routes //
// //////////////
Route::get('units', [UnitController::class, 'index'])->name('units');
Route::get('units/tree/{id}', [UnitController::class, 'tree']);
Route::get('units/one/{id}', [UnitController::class, 'show'])->name('unit/one');
Route::get('units/create', [UnitController::class, 'create']);
Route::get('units/edit/{id}', [UnitController::class, 'edit']);
Route::post('units/delete/{id}', [UnitController::class, 'destroy']);
Route::post('units/store', [UnitController::class, 'store']);
Route::post('units/update', [UnitController::class, 'update']);
Route::post('units/users', [UnitController::class, 'addUsers']);
Route::post('units/volunteers', [UnitController::class, 'addVolunteers']);
Route::post('units/search', [UnitController::class, 'search']);
Route::get('wholeTree', [UnitController::class, 'wholeTree']);

// ///////////////////
// Volunteer Routes //
// ///////////////////
Route::get('volunteers', [VolunteerController::class, 'index']);
Route::get('volunteers/create', [VolunteerController::class, 'create']);
Route::get('volunteers/new', [VolunteerController::class, 'newVolunteers']);
Route::get('volunteers/edit/{id}', [VolunteerController::class, 'edit']);
Route::post('volunteers/delete/{id}', [VolunteerController::class, 'destroy']);
Route::get('volunteers/one/{id}', [VolunteerController::class, 'show'])->name('volunteer/profile');
Route::post('volunteers/addToRootUnit/{id}', [VolunteerController::class, 'addToRootUnit']);
Route::post('volunteers/{volunteerId}/unit/detach/{unitId}', [VolunteerController::class, 'detachFromUnit']);
Route::post('volunteers/{volunteerId}/action/detach/{unitId}', [VolunteerController::class, 'detachFromAction']);
Route::post('volunteers/addToUnit', [VolunteerController::class, 'addToUnit']);
Route::post('volunteers/addToAction', [VolunteerController::class, 'addToAction']);
Route::post('volunteers/store', [VolunteerController::class, 'store']);
Route::post('volunteers/update', [VolunteerController::class, 'update']);
Route::post('volunteers/stepStatus/update', [VolunteerController::class, 'updateStepStatus']);
Route::post('volunteers/search', [VolunteerController::class, 'search']);
Route::post('volunteers/blacklisted', [VolunteerController::class, 'blacklisted']);
Route::post('volunteers/unblacklisted', [VolunteerController::class, 'unBlacklisted']);
Route::post('volunteers/notAvailable', [VolunteerController::class, 'notAvailable']);
Route::post('volunteers/available', [VolunteerController::class, 'available']);
Route::post('volunteers/deleteFile', [VolunteerController::class, 'deleteFile']);
Route::get('volunteers/publicForm', [VolunteerController::class, 'publicForm']);

// ////////////////
// Action Routes //
// ////////////////
Route::get('actions', [ActionController::class, 'index']);
Route::get('actions/one/{id}', [ActionController::class, 'show'])->name('action/one');
Route::get('actions/create', [ActionController::class, 'create']);
Route::get('actions/edit/{id}', [ActionController::class, 'edit']);
Route::post('actions/delete/{id}', [ActionController::class, 'destroy']);
Route::post('actions/store', [ActionController::class, 'store']);
Route::post('actions/update', [ActionController::class, 'update']);
Route::post('actions/volunteers', [ActionController::class, 'addVolunteers']);
Route::get('actions/ratings/{id}', [ActionController::class, 'fullRatings']);
Route::post('actions/search', [ActionController::class, 'search']);

// //////////////
// Task Routes //
// //////////////
Route::get('actions/tasks/one/{id}', [TaskController::class, 'show']);
Route::post('actions/tasks/store', [TaskController::class, 'store']);
Route::post('actions/tasks/update', [TaskController::class, 'update']);
Route::post('actions/tasks/delete/{id}', [TaskController::class, 'destroy']);

// //////////////////
// SubTask Routes //
// ////////////////
Route::get('actions/tasks/subtasks/one/{id}', [SubTaskController::class, 'show']);
Route::post('actions/tasks/subtasks/store', [SubTaskController::class, 'store']);
Route::post('actions/tasks/subtasks/update', [SubTaskController::class, 'update']);
Route::post('actions/tasks/subtasks/updateStatus', [SubTaskController::class, 'updateStatus']);
Route::post('actions/tasks/subtasks/delete/{id}', [SubTaskController::class, 'destroy']);

// //////////////////
// Shifts Routes //
// ////////////////
Route::post('actions/tasks/shifts/store', [TaskShiftController::class, 'store']);
Route::post('actions/tasks/shifts/update', [TaskShiftController::class, 'update']);
Route::post('actions/tasks/shifts/delete/{id}', [TaskShiftController::class, 'destroy']);
Route::post('actions/tasks/subtasks/shifts/store', [SubtaskShiftController::class, 'store']);
Route::post('actions/tasks/subtasks/shifts/update', [SubtaskShiftController::class, 'update']);
Route::post('actions/tasks/subtasks/shifts/delete/{id}', [SubtaskShiftController::class, 'destroy']);

// ////////////////////////
// Collaboration Routes //
// //////////////////////
Route::get('collaborations', [CollaborationController::class, 'index']);
Route::get('collaborations/one/{id}', [CollaborationController::class, 'show'])->name('collaboration/one');
Route::get('collaborations/create', [CollaborationController::class, 'create']);
Route::get('collaborations/edit/{id}', [CollaborationController::class, 'edit']);
Route::post('collaborations/delete/{id}', [CollaborationController::class, 'destroy']);
Route::post('collaborations/store', [CollaborationController::class, 'store']);
Route::post('collaborations/update', [CollaborationController::class, 'update']);
Route::post('collaborations/search', [CollaborationController::class, 'search']);
Route::post('collaborations/deleteFile', [CollaborationController::class, 'deleteFile']);

// //////////////
// Rating Routes //
// //////////////
Route::post('ratings/action/store', [RatingController::class, 'storeActionRating']);
Route::post('ratings/action/volunteers/store', [RatingController::class, 'storeVolunteersRating']);
Route::post('ratings/action/volunteers/delete/{id}', [RatingController::class, 'deleteVolunteerRating'])->middleware('auth');
Route::get('ratings/action/thankyou/{actionId}', [RatingController::class, 'actionThankyou']);
Route::get('ratings/action/volunteers/thankyou/{actionId}', [RatingController::class, 'volunteersThankyou']);
Route::get('ratings/action/{token}', [RatingController::class, 'rateAction']);
Route::get('rateVolunteers/{token}', [RatingController::class, 'rateVolunteers']);

// //////////////////
// Notifications //
// //////////////////

Route::post('stopBellNotification/{notificationId}', [NotificationController::class, 'stopBellNotification'])->name('notifications.stopBell');
Route::post('/deactivateNotification/{notificationId}', [NotificationController::class, 'deactivateNotification'])->name('notification.deactivate');
Route::get('/checkForNotifications', [NotificationController::class, 'checkForNotifications'])->name('notifications.check');
Route::get('notifications', [NotificationController::class, 'index']);

// ///////////////
// Search Route //
// ///////////////
Route::get('search/city', [SearchController::class, 'city'])->middleware('auth');
Route::get('search/country', [SearchController::class, 'country'])->middleware('auth');
Route::get('search/actionUser', [SearchController::class, 'actionUser'])->middleware('auth');
Route::get('search/collabType', [SearchController::class, 'collabType'])->middleware('auth');
Route::get('search/volunteers/firstName', [SearchController::class, 'volunteerFirstName'])->middleware('auth');
Route::get('search/volunteers/lastName', [SearchController::class, 'volunteerLastName'])->middleware('auth');
Route::get('search/volunteers/additionalSkills', [SearchController::class, 'volunteerAdditionalSkills'])->middleware('auth');
Route::get('search/volunteers/extraLang', [SearchController::class, 'volunteerExtraLang'])->middleware('auth');
Route::get('search/volunteers/workDescription', [SearchController::class, 'volunteerWorkDescription'])->middleware('auth');
Route::get('search/volunteers/specialty', [SearchController::class, 'volunteerSpecialty'])->middleware('auth');
Route::get('search/volunteers/department', [SearchController::class, 'volunteerDepartment'])->middleware('auth');
Route::get('search/volunteers/participationΑctions', [SearchController::class, 'volunteerParticipationΑctions'])->middleware('auth');
Route::get('search/volunteers/computerUsageComments', [SearchController::class, 'volunteerComputerUsageComments'])->middleware('auth');

// /////////////////
// Reports Routes //
// ////////////////
Route::get('reports', [ReportsController::class, 'index']);
Route::get('reports/idleVolunteers', [ReportsController::class, 'idleVolunteers']);
Route::get('reports/volunteersByMonth', [ReportsController::class, 'volunteersByMonth']);
Route::get('reports/volunteersBySex', [ReportsController::class, 'volunteersBySex']);
Route::get('reports/volunteersByAgeGroup', [ReportsController::class, 'volunteersByAgeGroup']);
Route::get('reports/volunteersByCity', [ReportsController::class, 'volunteersByCity']);
Route::get('reports/volunteersByEducationLevel', [ReportsController::class, 'volunteersByEducationLevel']);
Route::get('reports/volunteersByInterest', [ReportsController::class, 'volunteersByInterest']);
Route::get('reports/volunteersByAction', [ReportsController::class, 'volunteersByAction']);
Route::get('reports/volunteerHoursByAction', [ReportsController::class, 'volunteerHoursByAction']);
Route::get('reports/activeAndAvailableVolunteersByUnit', [ReportsController::class, 'activeAndAvailableVolunteersByUnit']);

// /////////////////
// CTA Routes //
// ////////////////
Route::get('cta', [CTAController::class, 'cta']);
Route::get('participate/{id}', [CTAController::class, 'participate']);
Route::post('cta/store', [CTAController::class, 'store']);
Route::post('cta/update', [CTAController::class, 'update']);
Route::post('cta/volunteerInterested', [CTAController::class, 'volunteerInterested']);

// /////////////////
// CTAVolunteer Routes //
// ////////////////
Route::post('ctaVolunteer/update', [CTAVolunteerController::class, 'update']);
Route::post('ctaVolunteer/delete/{id}', [CTAVolunteerController::class, 'destroy']);
Route::post('ctaVolunteer/assignToVolunteer', [CTAVolunteerController::class, 'assignToVolunteer']);

// /////////////////
// Checklist Routes //
// ////////////////
Route::post('actions/tasks/checklist/store', [TaskChecklistController::class, 'store']);
Route::post('actions/tasks/checklist/update', [TaskChecklistController::class, 'update']);
Route::post('actions/tasks/checklist/delete', [TaskChecklistController::class, 'delete']);
Route::post('actions/tasks/subtasks/checklist/store', [SubtaskChecklistController::class, 'store']);
Route::post('actions/tasks/subtasks/checklist/update', [SubtaskChecklistController::class, 'update']);
Route::post('actions/tasks/subtasks/checklist/delete', [SubtaskChecklistController::class, 'delete']);

// /////////////////
// Cron Routes ////
// ////////////////
Route::get('cron/checkActions', [CronController::class, 'checkActions'])->middleware('auth');

// ///////////////
// API Routes  //
// ///////////////
// Called by the public volunteer form of other sites: no login.
Route::post('api/volunteers/apiStore', [VolunteerApiController::class, 'apiStore']);

// Called by the pages of the application itself: login is necessary.
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('volunteers', [VolunteerApiController::class, 'all']);
    Route::get('volunteers/status/{status}', [VolunteerApiController::class, 'status']);
    Route::get('volunteers/one/{id}', [VolunteerApiController::class, 'show']);

    Route::get('units', [UnitApiController::class, 'all']);
    Route::get('units/{id}/volunteers', [UnitApiController::class, 'volunteers']);
    Route::get('units/{id}/actions', [UnitApiController::class, 'actions']);

    Route::get('users', [UserApiController::class, 'all']);

    Route::get('actions', [ActionApiController::class, 'all']);
    Route::get('actions/{id}/volunteers', [ActionApiController::class, 'volunteers']);
    Route::get('actions/calendar', [ActionApiController::class, 'calendar']);
    Route::get('actions/rating/{id}', [ActionApiController::class, 'rating']);

    Route::get('collaborations', [CollaborationApiController::class, 'all']);

    Route::get('tree', [TreeApiController::class, 'tree']);
    Route::get('tree/activeUnits/{id}', [TreeApiController::class, 'activeUnits']);
});

Route::get('faq', [EtcController::class, 'faq']);
