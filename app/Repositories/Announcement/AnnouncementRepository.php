<?php
namespace App\Repositories\Announcement;

use App\Models\User;
use App\Models\Usergroup;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementRepository implements IAnnouncementRepository {

    /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Announcement::buildQuery($data)
            ->with('image')
            ->orderBy('id', 'desc');
            
        if ($paginate) 
            return $query->paginate($limit);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function listMy(User $user, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $usergroup_ids = $user->usergroups
            ->pluck('id')
            ->toArray();

        $query = Announcement::with('image')
            ->where('audience', Announcement::AUDIENCE_USERGROUPS)
            ->whereIn('audience_data_id', $usergroup_ids)
            ->orWhere('audience', Announcement::AUDIENCE_ALL)
            ->orderBy('id', 'desc');

        if ($paginate) 
            return $query->paginate($limit);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function listMyAndPublished(User $user, $data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $usergroup_ids = $user->usergroups
            ->pluck('id')
            ->toArray();

        $query = Announcement::with('image')
            ->where('audience', Announcement::AUDIENCE_USERGROUPS)
            ->whereIn('audience_data_id', $usergroup_ids)
            ->orWhere('audience', Announcement::AUDIENCE_ALL)
            ->where('status', 'published')
            ->orderBy('id', 'desc');

        if ($paginate) 
            return $query->paginate($limit);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function listPendingForPublish(Carbon $scheduled_publish_date) {
        return Announcement::where('status', Announcement::STATUS_PENDING)
            ->where('scheduled_publish_date', $scheduled_publish_date)
            ->where('notification_sent', false)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Announcement::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function count($conditions = null) {
        $query = Announcement::query();

        if ($conditions)
            $query->where($conditions);

        return $query->count();
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        $data = $this->prepareData($data);
        $data['created_by'] = auth()->id();
        return Announcement::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Announcement $announcement, $data) {
        $data = $this->prepareData($data, $announcement);
        $data['updated_by'] = auth()->id();
        $announcement->fill($data);
        $announcement->save();
        
        return $announcement;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Announcement $announcement) {
        $announcement->image->delete();
        $announcement->delete();
    }

    private function prepareData($data, Announcement $announcement = null) {
        unset($data['status']);

        // reset status back to whatever it was
        if ($announcement)
            $data['status'] = $announcement->status;

        if ($data['audience'] == Announcement::AUDIENCE_ALL)
            unset($data['audience_data_id']);

        switch ($data['action']) {
            // check if has schedule date,
            // if yes, status = pending
            // if no, status = published
            case Announcement::ACTION_PUBLISH:
                if (isset($data['scheduled_publish_date']) && $data['scheduled_publish_date'] != null)
                    $data['status'] = Announcement::STATUS_PENDING;
                else 
                    $data['status'] = Announcement::STATUS_PUBLISHED;
                
                break;

            case Announcement::ACTION_SAVEDRAFT:
                $data['status'] = Announcement::STATUS_DRAFT;
                break;

            case Announcement::ACTION_UPDATE:
                // do nothing to change status
                // just update other data
                break;
        }

        if (!empty($data['scheduled_publish_date']))
            $data['scheduled_publish_date'] = Carbon::parse($data['scheduled_publish_date'])->toDateString();

        if ($data['status'] == Announcement::STATUS_PUBLISHED && empty($data['scheduled_publish_date']))
            $data['published_at'] = Carbon::now();

        return $data;
    }
}