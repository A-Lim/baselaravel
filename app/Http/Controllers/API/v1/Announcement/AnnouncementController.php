<?php
namespace App\Http\Controllers\API\v1\Announcement;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Notification;

use App\Models\User;
use App\Models\Announcement;

use App\Http\Requests\Announcement\CreateRequest;
use App\Http\Requests\Announcement\UpdateRequest;
use App\Repositories\Announcement\IAnnouncementRepository;
use App\Notifications\Announcement\AnnouncementPublished;

class AnnouncementController extends ApiController {

    private $announcementRespository;

    public function __construct(IAnnouncementRepository $iAnnouncementRespository) {
        $this->middleware('auth:api');
        $this->announcementRespository = $iAnnouncementRespository;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Announcement::class);
        $user = auth()->user();
        $announcement = null;
        // if admin, list all
        // if user, list relevant
        if ($user->isAdmin())
            $announcement = $this->announcementRespository->list($request->all(), true);
        else 
            $announcement = $this->announcementRespository->listMy($user, true);

        return $this->responseWithData(200, $announcement);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Announcement::class);

        $data = $this->prepareData($request->all());
        $announcement = $this->announcementRespository->create($data);

        // sent announcement notification
        if ($announcement->status == Announcement::STATUS_PUBLISHED &&
            $announcement->push_notification)
            Notification::send(null, new AnnouncementPublished($announcement));
        
        return $this->responseWithMessageAndData(201, $announcement, 'Announcement created.');
    }

    public function update(UpdateRequest $request, Announcement $announcement) {
        $this->authorize('update', $announcement);

        $data = $this->prepareData($request->all());
        $announcement = $this->announcementRespository->update($announcement, $data);

        // sent announcement notification
        if ($announcement->status == Announcement::STATUS_PUBLISHED && 
            $announcement->push_notification && 
            !$announcement->notification_sent)
            Notification::send(null, new AnnouncementPublished($announcement));
        
        return $this->responseWithMessageAndData(200, $announcement, 'Announcement updated.');
    }

    public function details(Announcement $announcement) {
        $this->authorize('view', $announcement);
        $announcement = $this->announcementRespository->find($announcement->id);
        return $this->responseWithData(200, $announcement);
    }

    public function delete(Announcement $announcement) {
        $this->authorize('delete', $announcement);

        $this->announcementRespository->delete($announcement);
        return $this->responseWithMessage(200, 'Announcement deleted.');
    }

    private function prepareData($data) {
        unset($data['status']);

        if ($data['audience'] == Announcement::AUDIENCE_ALL)
            unset($data['audience_data_id']);

        switch ($data['action']) {
            // check if has schedule date,
            // if yes, status = pending
            // if no, status = published
            case Announcement::ACTION_PUBLISH:
                if (isset($data['scheduled_publish_date']) && $data['scheduled_publish_date'] != null) {
                    $data['status'] = Announcement::STATUS_PENDING;
                } else {
                    $data['status'] = Announcement::STATUS_PUBLISHED;
                    $data['notification_sent'] = true;
                }
                break;

            case Announcement::ACTION_SAVEDRAFT:
                $data['status'] = Announcement::STATUS_DRAFT;
                break;

            case Announcement::ACTION_UPDATE:
                // do nothing to change status
                // just update other data
                break;
        }

        return $data;
    }
}