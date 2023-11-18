<?php
namespace App\Repositories\Client;

use App\Models\Client;

class ClientRepository implements IClientRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Client::buildQuery($data)
            ->orderBy('id', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function create($data) {
        return Client::create($data);
    }
    
    public function update(Client $client, $data) {
        $client->fill($data);
        $client->save();

        return $client;
    }
}