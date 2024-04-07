<?php

namespace App\Http\Controllers\API\v1\Package;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Package\CreateRequest;
use App\Http\Requests\Package\BulkCreateRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Repositories\Package\IPackageRepository;

class PackageController extends ApiController
{
    private $packageRepository;

    public function __construct(IPackageRepository $iPackageRepository) {
        $this->middleware('auth:api');
        $this->packageRepository = $iPackageRepository;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Package::class);

        $packages = $this->packageRepository->list($request->all(), true);
        return $this->responseWithData(200, $packages);
    }

    public function listAll(Request $request) {
        $this->authorize('viewAny', Package::class);

        $packages = $this->packageRepository->list([], false);
        return $this->responseWithData(200, $packages);
    }

    public function details(Package $package) {
        $this->authorize('view', $package);
        return $this->responseWithData(200, $package);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Package::class);
        $package = $this->packageRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $package, 'Package created.');
    }

    public function bulkCreate(BulkCreateRequest $request) {
        $this->authorize('create', Package::class);
        $this->packageRepository->createBulk($request->all());
        return $this->responseWithMessage(201, 'Packages created.');
    }

    public function update(UpdateRequest $request, Package $package) {
        $this->authorize('update', $package);
        $package = $this->packageRepository->update($package, $request->all());
        return $this->responseWithMessageAndData(200, $package, 'Package updated.');
    }

    public function delete(Package $package) {
        $this->authorize('delete', $package);
        $this->packageRepository->delete($package);
        return $this->responseWithMessage(200, 'Package deleted.');
    }
}
