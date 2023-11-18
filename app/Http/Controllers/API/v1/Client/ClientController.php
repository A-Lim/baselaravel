<?php

namespace App\Http\Controllers\API\v1\Client;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Client\CreateRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Repositories\Client\IClientRepository;

class ClientController extends ApiController {

    private $clientRepository;

    public function __construct(IClientRepository $iClientRepository) {
        $this->middleware('auth:api');
        $this->clientRepository = $iClientRepository;
    }

    public function list(Request $request) {
        $clients = $this->clientRepository->list($request->all());
        return $this->responseWithData(200, $clients);
    }

    public function create(CreateRequest $request, Client $client) {
        $this->clientRepository->create($request->all());
        return $this->responseWithMessage(200, 'Client created.');
    }

    public function update(UpdateRequest $request, Client $client) {
        $this->clientRepository->update($client, $request->all());
        return $this->responseWithMessage(200, 'Client updated.');
    }
}
