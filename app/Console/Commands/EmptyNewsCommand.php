<?php

namespace App\Console\Commands;

use App\Events\NewsWasUpdatedEvent;
use App\Models\News;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Console\Command;

class EmptyNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'empty:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty News collection';

    public function handle()
    {
        News::truncate();
        NewsWasUpdatedEvent::broadcast();

        return self::SUCCESS;
    }
}
