<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;
use App\Models\Announcement;
use App\Notifications\Announcement\AnnouncementPublished;
use App\Repositories\Announcement\IAnnouncementRepository;

class PublishAnnouncements extends Command {

    private $announcementRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcements:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish pending announcements and send notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IAnnouncementRepository $iAnnouncementRepository) {
        parent::__construct();
        $this->announcementRepository = $iAnnouncementRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('<comment>Publishing announcements...</comment>');

        $announcements = $this->announcementRepository->listPendingForPublish(Carbon::today());

        foreach ($announcements as $announcement) {
            $output->writeln('<comment>Processing announcement ('.$announcement->title.')...</comment>');
            $announcement->status = Announcement::STATUS_PUBLISHED;
            $announcement->published_at = Carbon::now();
            
            $output->writeln('<info> Announcement '.ucfirst($announcement->status).'</info>');
            
            if ($announcement->push_notification) {
                Notification::send(null, new AnnouncementPublished($announcement));
                $announcement->notification_sent = true;
                $output->writeln('<info> Notification Sent</info>');
            }

            // TODO:: optimize 
            // bulk save instead of 1 by 1
            $announcement->save();
        }
        return 0;
    }
}
