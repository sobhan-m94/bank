<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\WithdrawRequest;
use App\Repository\TransactionRepository;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    private $transactionRepository;
    public function __construct(TransactionRepository  $transactionRepositor)
    {
        $this->transactionRepository   = $transactionRepositor;
    }
    public function withdraw(WithdrawRequest $request)
    {
        $withdraw = $this->transactionRepository->withdraw($request->sender, $request->receiver, $request->amount);
        if ($withdraw) {
            return $this->successResponse();
        }
        return $this->errorResponse('transaction failed', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
