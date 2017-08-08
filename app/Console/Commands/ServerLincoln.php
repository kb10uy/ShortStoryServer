<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\ServerInformed;

class ServerLincoln extends Command
{
    protected $signature = 'server:lincoln';

    protected $description = 'Lincoln the server.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        event(new ServerInformed('んほぉ♥♥♥'));
    }
}
