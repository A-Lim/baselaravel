<?php
namespace App\Http\Controllers\API\v1\Announcement;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Notification;
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
        $announcements = null;
        // if admin, list all
        // if user, list relevant
        if ($user->isAdmin())
            $announcements = $this->announcementRespository->list($request->all(), true);
        else
            $announcements = $this->announcementRespository->listMy($user, true);

        return $this->responseWithData(200, $announcements);
    }

    public function listMy(Request $request) {
        $user = auth()->user();
        $announcements = $this->announcementRespository->listMyAndPublished($user, $request->all(), true);
        return $this->responseWithData(200, $announcements);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Announcement::class);
        $announcement = $this->announcementRespository->create($request->all());

        // sent announcement notification
        if ($announcement->status == Announcement::STATUS_PUBLISHED &&
            $announcement->push_notification)
            Notification::send(null, new AnnouncementPublished($announcement));

        return $this->responseWithMessageAndData(201, $announcement, 'Announcement created.');
    }

    public function update(UpdateRequest $request, Announcement $announcement) {
        $this->authorize('update', $announcement);
        $announcement = $this->announcementRespository->update($announcement, $request->all());

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
}
