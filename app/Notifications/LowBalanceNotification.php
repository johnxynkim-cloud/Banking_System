<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LowBalanceNotification extends Notification {
    use Queueable;

    protected $account;

    public function __construct($account) {
        $this->account = $account;
    }

    public function via($notifiable): array {
        return ['database'];
    }

    public function toArray($notifiable): array {
        return [
            'account_id' => $this->account->id,
            'account_number' => $this->account->account_number,
            'balance' => $this->account->balance,
            'message' => "Warning: Your account ({$this->account->account_number}) balance is at {$this->account->balance}, which is at or below your minimum threshold.",
        ];
    }
}