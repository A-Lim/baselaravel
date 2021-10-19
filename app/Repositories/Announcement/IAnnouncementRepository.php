<?php
namespace App\Repositories\Announcement;

use App\Models\User;
use App\Models\Announcement;
use Carbon\Carbon;

interface IAnnouncementRepository {
    /**
     * List all announcements
     * @param array $data
     * @param boolean $paginate = false
     * @return array Announcement
     */
    public function list($data, $paginate = false);

    /**
     * List announcements by user
     * @param User $user
     * @param boolean $paginate = false
     * @return array Announcement
     */
    public function listMy(User $user, $paginate = false);

    /**
     * List published announcement related to user
     * @param User $user
     * @param array $data
     * @param boolean $paginate = false
     * @return array Announcement
     */
    public function listMyAndPublished(User $user, $data, $paginate = false);

    /**
     * List pending announcements by scheduled publish date
     * @param Carbon $date
     * @return array Announcement
     */
    public function listPendingForPublish(Carbon $scheduled_publish_date);

    /**
     * Creates an announcement
     * @param array $data
     * @return Announcement announcement
     */
    public function create($data);

    /**
     * Updates an announcement
     * @param Announcement $announcement
     * @param array $data
     * @param Announcement announcement
     */
    public function update(Announcement $announcement, $data);

    /**
     * Find an announcement by id
     * @param integer id
     * @param Announcement announcement
     */
    public function find($id);

    /**
     * Count announcements
     * 
     * @param array $conditions
     * @return array Announcement
     */
    public function count($conditions = null);

    /**
     * Deletes an announcement
     * @param Announcement $announcement
     * @param void
     */
    public function delete(Announcement $announcement);
}