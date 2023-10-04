<?php

namespace App\Http\Requests\Transaction;

use App\Rules\CardNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender' => [
                'bail',
                'required',
                'integer',
                'digits:16',
                new CardNumberRule,
                Rule::exists('cards', 'card_number')->where('user_id', Auth::user()->id)
            ],
            'receiver' => [
                'bail',
                'required',
                'integer',
                'digits:16',
                new CardNumberRule,
                'different:sender',
                Rule::exists('cards', 'card_number')
            ],
            'amount' => [
                'bail',
                'required',
                'integer',
                'min:1000',
                'max:50000000'
            ]
        ];
    }
}
