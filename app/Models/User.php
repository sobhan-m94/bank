<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public static function lock()
    {
        return self::select('id')->where('id', Auth::user()->id)->lockForUpdate()->first();
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function scopeMostActive()
    {
        $users = DB::table('balances as b')->select('user_id', DB::raw('count(b.id) as tcount'))
            ->from('cards as c')
            ->join('balances as b', 'b.card_id', '=', 'c.id')
            ->where('b.created_at', '>', now()->subMinutes(10))
            ->groupBy('user_id')
            ->orderBy('tcount', 'desc')
            ->limit(3)
            ->get()->pluck('user_id');
        return self::whereIn('id', $users);
    }

    public function scopeRecentTransactions()
    {
        $transactions = DB::table('balances as b')->select('t.id as transaction_id')
            ->from('transactions as t')
            ->join('cards as c', function ($query) {
                $query->on('t.sender_card_id', '=', 'c.id')
                    ->orOn('t.receiver_card_id', '=', 'c.id');
            })
            ->where('c.user_id', '=', $this->id)
            ->orderBy('t.id', 'desc')
            ->limit(10)->get()->pluck('transaction_id');
        return Transaction::whereIn('id', $transactions);
    }
}
