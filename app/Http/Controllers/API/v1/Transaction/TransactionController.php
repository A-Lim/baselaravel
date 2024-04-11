<?php

namespace App\Http\Controllers\API\v1\Transaction;

use App\Models\Transaction;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Transaction\CreateRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Repositories\Transaction\ITransactionRepository;

class TransactionController extends ApiController
{
    private $transactionRepository;

    public function __construct(ITransactionRepository $iTransactionRepository) {
        $this->middleware('auth:api');
        $this->transactionRepository = $iTransactionRepository;
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Transaction::class);
        $transaction = $this->transactionRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $transaction, 'Transaction created.');
    }

    public function update(UpdateRequest $request, Transaction $transaction) {
        $this->authorize('update', $transaction);
        $transaction = $this->transactionRepository->update($transaction, $request->validated());
        return $this->responseWithMessageAndData(201, $transaction, 'Transaction updated.');
    }

    public function delete(Transaction $transaction) {
        $this->authorize('delete', $transaction);
        $this->transactionRepository->delete($transaction);
        return $this->responseWithMessage(200, 'Transaction deleted.');
    }
}
