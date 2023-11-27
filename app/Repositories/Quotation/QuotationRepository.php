<?php
namespace App\Repositories\Quotation;

use Illuminate\Support\Facades\DB;
use App\Models\Quotation;
use App\Models\Client;

class QuotationRepository implements IQuotationRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Quotation::buildQuery($data)
            ->orderBy('id', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function find($id) {
        return Quotation::with('client', 'quotation_items')
            ->where('id', $id)
            ->firstOrFail();
    }

    public function create($data) {
        DB::beginTransaction();
            $data['version'] = 1;
            $quotation = $this->createQuotation($data);
        DB::commit();

        return $this->find($quotation->id);
    }

    public function createRevision(Quotation $quotation, $data) {
        DB::beginTransaction();
            $data['version'] = $quotation->version + 1;
            $revision = $this->createQuotation($data);
            $quotation->update(['status' => Quotation::STATUS_OBSOLETE]);
        DB::commit();

        return $this->find($revision->id);
    }
    
    public function update(Quotation $quotation, $data) {
        $quotation->fill($data);
        $quotation->save();

        return $quotation;
    }

    private function createQuotation($data) {
        if (!isset($data['client_id'])) {
            $client = Client::create([
                'name' => $data['client_name'],
                'type' => $data['client_type'],
                'ssm_no' => $data['client_ssm_no'],
                'email' => $data['client_email'],
                'phone' => $data['client_phone'],
                'address' => $data['client_address'],
            ]);
            $data['client_id'] = $client->id;
        }

        $data['status'] = Quotation::STATUS_CURRENT;
        
        $quotation = Quotation::create($data);
        $quotation->quotation_items()->createMany($data['quotation_items']);

        return $quotation;
    }
}