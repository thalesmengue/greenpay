<?php

namespace App\Services;

use App\Client\AuthorizationClient;
use App\Client\NotificationClient;
use App\Exceptions\TransactionException;
use App\Exceptions\UserException;
use App\Exceptions\WalletException;
use App\Models\Transaction;
use App\Models\Wallet;


class TransactionService
{
    public function __construct(
        private NotificationClient $notification,
        private AuthorizationClient $authorization
    )
    {
    }


    public function transaction(array $data): array
    {
        $payer = Wallet::query()->with('user')->where('keeper_id', '=', $data['payer_id'])->first();
        $receiver = Wallet::query()->where('keeper_id', '=', $data['receiver_id'])->first();
        $amount = $data['amount'];

        if ($payer->user->role === 'shopkeeper') {
            throw UserException::cantSendTransaction();
        }

        if ($payer->balance < $amount) {
            throw WalletException::insufficientBalance();
        }

        if ($this->authorization->authorize() !== "Autorizado") {
            throw TransactionException::transactionUnauthorized();
        }

        $payer->decrement('balance', $amount);
        $receiver->increment('balance', $amount);

        $transaction = Transaction::create([
            'payer_id' => $payer->id,
            'receiver_id' => $receiver->id,
            'amount' => $amount,
        ]);

        if ($this->notification->notify() !== "Success") {
            throw TransactionException::unavailabilityToSendEmail();
        }

        return [
            'transaction' => $transaction,
            'payer' => $payer,
            'receiver' => $receiver
        ];
    }
}
