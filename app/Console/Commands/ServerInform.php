<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\ServerInformed;

class ServerInform extends Command
{
    protected $signature = 'server:inform {message}';

    protected $description = 'Send global information message.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        event(new ServerInformed($this->argument('message')));
        $this->info('Sent server message successfully.');
    }
}
