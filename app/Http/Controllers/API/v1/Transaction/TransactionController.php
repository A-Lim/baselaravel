<?php

namespace App\Http\Controllers\API\v1\Transaction;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Transaction\CreateRequest;
use App\Repositories\Transaction\ITransactionRepository;

class TransactionController extends ApiController
{
    private $transactionRepository;

    public function __construct(ITransactionRepository $iTransactionRepository) {
        $this->middleware('auth:api');
        $this->transactionRepository = $iTransactionRepository;
    }

    // public function list(Request $request) {
    //     // $this->authorize('viewAny', Transaction::class);

    //     $transactions = $this->transactionRepository->list($request->all(), true);
    //     return $this->responseWithData(200, $transactions);
    // }

    // public function details(Customer $transaction) {
    //     $this->authorize('view', $transaction);
    //     return $this->responseWithData(200, $transaction);
    // }

    public function create(CreateRequest $request) {
        // $this->authorize('create', Customer::class);
        $transaction = $this->transactionRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $transaction, 'Transaction created.');
    }
}
