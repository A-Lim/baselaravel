<?php
namespace App\Repositories\Announcement;

use App\Models\User;
use App\Models\Announcement;
use Carbon\Carbon;

interface IAnnouncementRepository {

    public function list($data, $paginate = false);

    public function listMy(User $user, $paginate = false);

    public function listMyAndPublished(User $user, $data, $paginate = false);

    public function listPendingForPublish(Carbon $scheduled_publish_date);

    public function create($data);

    public function update(Announcement $announcement, $data);

    public function find($id);

    public function count($conditions = null);

    public function delete(Announcement $announcement);
}