<?php namespace App\Console\Commands;

use App\Models\Action as Action;
use Illuminate\Console\Command;

class CheckActions extends Command {


    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'checkActions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find expired actions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //dd(\Config::get('mail'));
        $this->comment('I was here @ ' . \Carbon::now());

        $expiredActions = Action::expiredYesterday()->with('volunteers')->get();

        $this->comment(sizeof($expiredActions).' expired actions');

        foreach ($expiredActions as $expired) {

            foreach ($expired->volunteers as $volunteer) {
                \Mail::send('emails.test', ['volunteer' => $volunteer], function ($message) use($volunteer) {
                    $message->to($volunteer->email, $volunteer->name.' '.$volunteer->last_name)->subject('Test');
                });

                $this->comment('Send email to '.$volunteer->name.' '.$volunteer->last_name.' ['.$volunteer->email.']');
            }

        }

    }
}
