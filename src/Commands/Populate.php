<?php

namespace Meops\Populate\Commands;

use Illuminate\Console\Command;

class Populate extends Command
{
    protected $signature = 'populate {className}';


    public function handle(): void
    {
        $this->info('Command is running');
    }
}