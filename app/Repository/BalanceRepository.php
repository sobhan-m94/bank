<?php

namespace App\Repository;

use App\Events\NewTransactionEvent;
use App\Exceptions\AppException;
use App\Models\Balance;
use App\Models\Card;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BalanceRepository
{
    private $fee;

    public function __construct()
    {
        $this->fee = config('transactions.fee');
    }

    public function take($card, $amount)
    {
        $balance = new Balance();
        $balance->fill([
            'card_id' => $card->id,
            'current' => ($current = $card->balance),
            'add' => 0,
            'take' => $amount,
            'balance' => $current - ($amount + $this->fee),
            'fee' => $this->fee,
        ]);
        return $balance->save();
    }

    public function add($card, $amount)
    {
        $balance = new Balance();
        $balance->fill([
            'card_id' => $card->id,
            'current' => ($current = $card->balance),
            'add' =>  $amount,
            'take' => 0,
            'balance' => $current + $amount,
        ]);
        return $balance->save();
    }
}
