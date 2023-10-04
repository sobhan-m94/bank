واریز به حساب {{ $transaction->receiver->account->account_number }}
شماره کارت : {{ $transaction->receiver->card_number }}

ارسال کننده : {{ $transaction->sender->card_number }}

مبلغ : {{ number_format($transaction->amount) }} تومان

تاریخ : {{ $transaction->created_at }}
