<?php
namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Models\User;

interface INotificationRepository
{
    public function list(User $user, $data, $paginate = false);

    public function countUnread(User $user);

    public function create($users, $notification_log_id, $notification_data);

    public function log($data);

    public function read(Notification $notification);

    public function markAllAsRead(User $user);

    public function delete(Notification $notification);
}