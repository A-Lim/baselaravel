<?php
namespace App\Repositories\Package;

use App\Models\Package;
use Carbon\Carbon;

class PackageRepository implements IPackageRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Package::buildQuery($data)
            ->orderBy('id', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function find($id) {
        return Package::find($id);
    }

    public function create($data) {
        $data['created_by'] = auth()->id();
        return Package::create($data);
    }

    public function createBulk($data) {
        $bulkInsert = [];
        $now = Carbon::now();
        $authorId = auth()->id();

        foreach ($data as $row) {
            array_push($bulkInsert, [
                'name' => $row['name'],
                'default_count' => $row['default_count'],
                'default_price' => $row['default_price'],
                'description' => $row['description'],
                'created_at' => $now,
                'updated_at' => $now,
                'created_by' => $authorId,
            ]);
        }
        
        Package::insert($bulkInsert);
    }

    public function update(Package $package, $data) {
        $data['updated_by'] = auth()->id();
        $package->fill($data);
        $package->save();

        return $package;
    }

    public function delete(Package $package) {
        $package->delete();
    }
}
