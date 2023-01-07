<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Exceptions\WalletException;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    )
    {
    }

    public function transaction(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->transactionService->transaction($request->all())
        ], Response::HTTP_OK);
    }
}
