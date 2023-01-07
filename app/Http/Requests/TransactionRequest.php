<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payer_id' => ['required'],
            'receiver_id' => ['required'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ];
    }


}
