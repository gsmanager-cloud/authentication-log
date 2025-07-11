<?php

namespace GSManager\AuthenticationLog\Console;

use GSManager\Console\Command;
use GSManager\Support\Carbon;
use GSManager\AuthenticationLog\AuthenticationLog;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authentication-log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old records from the authentication log';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Clearing authentication log...');

        $days = config('authentication-log.older');
        $from = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');

        AuthenticationLog::where('login_at', '<', $from)->delete();

        $this->info('Authentication log cleared successfully.');
    }
}
