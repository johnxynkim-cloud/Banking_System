<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Notifications\LowBalanceNotification;
use Exception;

class TransactionObserver {
    public function creating(Transaction $transaction): void {
        $account = $transaction->account;

        if ($transaction->type === 'deposit') {
            $account->balance += $transaction->amount;
        } elseif (in_array($transaction->type, ['withdrawal', 'transfer'])) {
            $newBalance = $account->balance - $transaction->amount;
            
            if ($newBalance < $account->minimum_balance) {
                throw new Exception("Transaction denied: Balance cannot fall below the minimum threshold of {$account->minimum_balance}.");
            }
            
            $account->balance = $newBalance;
        }

        $account->save();
    }
}