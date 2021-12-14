<?php

namespace App\Console\Commands;

use App\Events\NewsWasUpdatedEvent;
use App\Models\News;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateNewsCommand extends Command
{
    const FEED_URL = 'http://feeds.bbci.co.uk/news/rss.xml';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get latest news from BBC RSS feed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $feed = simplexml_load_file(self::FEED_URL);
        foreach ($feed->channel->item as $item) {
            $id = $this->addFeedItemToDatabase($item);
            $this->output->info('Added '.(string)$item->title . ' as ' . $id);
        }

        NewsWasUpdatedEvent::broadcast();
        return self::SUCCESS;
    }

    private function addFeedItemToDatabase(\SimpleXMLElement $item): int
    {
        $newsRecord = News::firstOrNew(['url' => (string)$item->guid]);
        $newsRecord->title = (string)$item->title;
        $newsRecord->description = (string)$item->description;
        $newsRecord->date = Carbon::createFromTimestamp(strtotime($item->pubDate));
        $newsRecord->save();

        return $newsRecord->id;
    }
}
