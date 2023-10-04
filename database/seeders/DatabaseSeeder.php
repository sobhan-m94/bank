<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Balance;
use App\Models\Card;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ['mobile' => (array) [cards]]
        foreach (['09367287143' => ['6104337303523383', '5859831055135825'], '09368961831' => ['6037998252382998', '5022291032319368']] as $mobile => $cards) {
            $user = \App\Models\User::factory()->create([
                'mobile' => $mobile,
            ]);

            $account = Account::factory()->count(1)->for($user)->create();

            foreach ($cards as $cardNumber) {

                $card = Card::create([
                    'account_id' => $account[0]->id,
                    'user_id' => $user->id,
                    'card_number' => $cardNumber,
                ]);
                $balance = 1500000;
                Balance::create([
                    'card_id' => $card->id,
                    'current' => 0,
                    'add' => $balance,
                    'take' => 0,
                    'balance' => $balance,
                ]);
            }
        }
    }
}
