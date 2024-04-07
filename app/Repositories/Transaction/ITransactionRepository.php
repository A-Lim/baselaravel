<?php
namespace App\Repositories\Transaction;

interface ITransactionRepository {

    public function list($data, $paginate = false);

    public function create($data);
}