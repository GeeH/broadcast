<?php

namespace App\Console\Commands;

use App\Events\SomethingCoolHappened;
use Illuminate\Console\Command;

class DoTheCoolThingCommand extends Command
{
    protected $signature = 'dispatch:event';
    protected $description = 'Command description';

    public function handle(): int
    {
        $this->output->info('Imma gonna do something cool');

        SomethingCoolHappened::broadcast();

        $this->output->info('Cool thing done.');
        return self::SUCCESS;
    }
}
