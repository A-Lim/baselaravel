<?php
namespace App\Repositories\Quotation;

use App\Models\Quotation;

interface IQuotationRepository {

    public function list($data, $paginate = false);

    public function create(array $data);

    public function createRevision(Quotation $quotation, array $data);

    public function update(Quotation $quotation, array $data);
}
