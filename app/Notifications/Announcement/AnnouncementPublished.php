<?php

namespace App\Notifications\Announcement;

use Illuminate\Notifications\Notification;

use App\Channels\CustomFCMChannel;
use App\Models\Announcement;

class AnnouncementPublished extends Notification {
    private $announcement;
    
    public function __construct(Announcement $announcement) {
        $this->announcement = $announcement;
    }

    public function via($notifiable) {
        return [CustomFCMChannel::class];
    }

    public function toCustomFCM($notifiable) {
        $notification_data = [
            'title' => $this->announcement->title,
            'body' => $this->announcement->description,
            'redirect' => true,
            'type' => 'announcements',
            'type_id' => $this->announcement->id
        ];

        $this->announcement->update(['notification_sent' => true]);

        return [
            'topic' => $this->announcement->audience,
            'payload' => $notification_data
        ];
    }
}
