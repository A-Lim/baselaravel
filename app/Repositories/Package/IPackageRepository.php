<?php
namespace App\Repositories\Package;

use App\Models\Package;

interface IPackageRepository {

    public function list($data, $paginate = false);

    public function create($data);

    public function update(Package $package, $data);

    public function find($id);

    public function delete(Package $package);
}