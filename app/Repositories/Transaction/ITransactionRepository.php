<?php
namespace App\Repositories\Transaction;

use App\Models\Transaction;

interface ITransactionRepository {

    public function list($data, $paginate = false);

    public function create($data);

    public function update(Transaction $transaction, $data);
}