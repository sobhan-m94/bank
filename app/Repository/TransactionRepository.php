<?php

namespace App\Repository;

use App\Events\NewTransactionEvent;
use App\Exceptions\AppException;
use App\Models\Card;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    private $balanceRepository;
    private $fee;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
        $this->fee = config('transactions.fee');
    }

    public function withdraw($sender, $receiver, $amount)
    {
        DB::beginTransaction();
        try {
            $amountWithFee = $amount + $this->fee;

            // قفل کردن رکورد برای جلوگیری از پردازش های همزمان و رخ دادم مغایرت مالی
            // در حالت قفل،سایر پردازش های همزمان،امکان خواندن رکورد را ندارند و تا پایان تراکنش،منتظر میمانند
            $sender = Card::where('card_number', $sender)->lockForUpdate()->first();
            $balance = $sender->balance;

            if ($balance < $amountWithFee) {
                throw new AppException('balance is not enough.', Response::HTTP_NOT_ACCEPTABLE);
            }

            $receiver = Card::where('card_number', $receiver)->lockForUpdate()->first();

            $transaction = $sender->withdrawTransactions()->create([
                'receiver_card_id' => $receiver->id,
                'amount' => $amount,
            ]);


            $take = $this->balanceRepository->take($sender, $transaction->amount);
            $add = $this->balanceRepository->add($receiver, $transaction->amount);

            if (!($add && $take)) {
                throw new Exception('failed');
            }
            NewTransactionEvent::dispatch($transaction);
            DB::commit();
            return true;
        } catch (AppException $e) {
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
