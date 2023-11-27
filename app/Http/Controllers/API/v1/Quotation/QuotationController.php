<?php

namespace App\Http\Controllers\API\v1\Quotation;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Quotation\CreateRequest;
use App\Http\Requests\Quotation\UpdateRequest;
use App\Http\Requests\Quotation\CreateRevisionRequest;
use App\Repositories\Quotation\IQuotationRepository;

use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends ApiController {

    private $quotationRepository;
    private $clientRepository;

    public function __construct(IQuotationRepository $iQuotationRepository) {
        $this->middleware('auth:api');
        $this->quotationRepository = $iQuotationRepository;
    }

    public function pdf() {
        $pdf = Pdf::loadView('pdfs.quotation');
        // return $pdf->download('quotation.pdf');
        return $pdf->stream();
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Quotation::class);
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasStore($request->input('store_id'))) {
            return $this->responseWithMessage(403, 'You are not permitted to create quotation for this store.');
        }

        $data = $request->all();
        $data['created_by'] = $user->id;
        $quotation = $this->quotationRepository->create($data);
        return $this->responseWithMessageAndData(201, $quotation, 'Quotation created.');
    }

    public function createRevision(CreateRevisionRequest $request, Quotation $quotation) {
        $this->authorize('create', Quotation::class);
        $user = auth()->user();

        $data = $request->all();
        $data['created_by'] = $user->id;
        $revision = $this->quotationRepository->createRevision($quotation, $data);
        return $this->responseWithMessageAndData(201, $revision, 'Quotation revision created.');
    }
}
