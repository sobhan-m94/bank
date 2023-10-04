<?php

namespace App\Http\Controllers;

use App\Http\Resources\MostActiveUsers;
use App\Models\User;

class ReportController extends Controller
{
    public function mostActiveUsers()
    {
        $users = User::mostActive()->get();
        
        $out = [];
        foreach ($users as $user) {
            $out[] = [
                'name' => $user->name,
                'transactions'=>$user->recentTransactions()->orderBy('id','desc')->get()->toArray(),
            ];
        }
        return new MostActiveUsers($out);
    }
}
