<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function withdrawTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_card_id');
    }

    public function depositTransactions()
    {
        return $this->hasMany(Transaction::class, 'receiver_card_id');
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Balance::where('card_id', $attributes['id'])->latest('id')->first()->balance ?? 0,
        );
    }
}
