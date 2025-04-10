<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\TransactionService;
use Carbon\Carbon;
class PDFController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService){
        $this->transactionService = $transactionService;
    }

    public function generateAllTransactionOutgoing(Request $request){
        $startDate = $request->input("start_date");
        $endDate = $request->input("end_date");
        $status = $request->input("status");
        $data = $this->transactionService->findAllOutgoing($startDate,$endDate,$status);
        $pdf = Pdf::loadView('pdf.transaction-outgoing.generateAllTransaction',compact('data'));
        return $pdf->download('all-invoice.pdf');
    }

    public function generateOneTransactionOutgoing(Request $request){
        $id = $request->input("id");
        $item = $this->transactionService->findTransactionOutgoingById($id);
        $pdf = Pdf::loadView("pdf.transaction-outgoing.generateOneTransactionOutgoing",compact("item"));
        $name = Carbon::parse($item->date)->format('Y-M')."-".$id;
        return $pdf->download("invoice-$name.pdf");
    }

    
}
