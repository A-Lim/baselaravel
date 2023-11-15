<?php
namespace App\Repositories\Notification;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationLog;

class NotificationRepository implements INotificationRepository {

    public function list(User $user, $data, $paginate = false) {
        $query = Notification::where('user_id', $user->id)
            ->orderBy('id', 'desc');

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->simplePaginate($limit);
        }

        return $query->get();
    }

    public function countUnread(User $user) {
        return Notification::where('user_id', $user->id)
            ->where('read', false)
            ->count();
    }

    public function create($user_ids, $notification_log_id, $notification_data) {
        $data = [];
        // remove redundant data from payload
        $payload = $notification_data;
        unset($payload['title']);
        unset($payload['body']);

        foreach ($user_ids as $user_id) {
            array_push($data, [
                'user_id' => $user_id,
                'notification_log_id' => $notification_log_id,
                'title' => $notification_data['title'],
                'description' => $notification_data['body'],
                'payload' => json_encode($payload),
                'created_at' => Carbon::now()
            ]);
        }
        // if data count more than 100, consider chunk inserts instead
        Notification::insert($data);
    }

    public function log($data) {
        return NotificationLog::create($data);
    }

    public function read(Notification $notification) {
        $notification->read = true;
        $notification->save();
    }

    public function markAllAsRead(User $user) {
        Notification::where('user_id', $user->id)
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function delete(Notification $notification) {
        $notification->delete();
    }
}
