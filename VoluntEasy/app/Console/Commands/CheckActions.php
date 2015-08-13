<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Volunteer as Volunteer;
use App\Models\Action as Action;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

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
    public function handle()
    {
        $this->comment('I was here @ ' . \Carbon::now());

        $expiredActions = Action::expiredYesterday()->get();

        $this->comment($expiredActions);

    }
}
