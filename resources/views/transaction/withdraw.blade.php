برداشت از حساب {{ $transaction->sender->account->account_number }}
شماره کارت : {{ $transaction->sender->card_number }}

گیرنده : {{ $transaction->receiver->card_number }}

مبلغ : {{ number_format($transaction->amount) }} تومان

تاریخ : {{ $transaction->created_at }}
