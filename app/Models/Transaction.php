<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(Card::class, 'sender_card_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Card::class, 'receiver_card_id');
    }

    public function destCard()
    {
        return $this->belongsTo(Card::class, 'to_card_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender->card_number,
            'receiver' => $this->receiver->card_number,
            'amount' => $this->amount,
            'time' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
