<?php
namespace App\Repositories\Client;

use App\Models\Client;

interface IClientRepository {

    public function list($data, $paginate = false);

    public function create(array $data);

    public function update(Client $client, array $data);
}
