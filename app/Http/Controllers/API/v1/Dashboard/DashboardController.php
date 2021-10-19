<?php

namespace App\Http\Controllers\API\v1\Dashboard;

use App\Models\Dashboard;
use App\Models\Widget;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard\CreateRequest;
use App\Http\Requests\Dashboard\UpdateRequest;
use App\Repositories\Dashboard\IDashboardRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\Announcement\IAnnouncementRepository;

class DashboardController extends ApiController {

    private $dashboardRepository;
    private $userRepository;
    private $announcementRepository;

    public function __construct(IDashboardRepository $iDashboardRespository,
        IUserRepository $iUserRepository,
        IAnnouncementRepository $iAnnouncementRepository) {
        $this->middleware('auth:api');
        $this->dashboardRepository = $iDashboardRespository;
        $this->userRepository = $iUserRepository;
        $this->announcementRepository = $iAnnouncementRepository;
    }

    public function listWidgetTypes() {
        $widgetTypes = $this->dashboardRepository->listWidgetTypes();
        $category = $widgetTypes->groupBy('category');
        return $this->responseWithData(200, $category);
    }

    public function list() {
        $user = auth()->user();
        $dashboards = $this->dashboardRepository->list($user);
        return $this->responseWithData(200, $dashboards);
    }

    public function data(Dashboard $dashboard) {
        $widgets = $dashboard->widgets;
        $data = [];

        foreach ($widgets as $widget) {
            $data[$widget->uuid] = $this->getWidgetData($widget);
        }

        return $this->responseWithData(200, $data);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Dashboard::class);
        $dashboard = $this->dashboardRepository->create($request->all(), auth()->user());

        return $this->responseWithMessageAndData(201, $dashboard, 'Dashboard created.');
    }

    public function update(UpdateRequest $request, Dashboard $dashboard) {
        $this->authorize('create', Dashboard::class);
        $dashboard = $this->dashboardRepository->update($dashboard, $request->all(), auth()->user());

        return $this->responseWithMessageAndData(200, $dashboard, 'Dashboard updated.');
    }

    private function getWidgetData(Widget $widget) {
        switch ($widget->type) {
            case Widget::TYPE_USERS_COUNT:
                return $this->userRepository->count();

            case Widget::TYPE_ANNOUNCEMENTS_COUNT:
                return $this->announcementRepository->count();
        }
    }
}
