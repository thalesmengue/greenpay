<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Document implements Rule
{
    public function passes($attribute, $value): bool
    {
        //validate if the number has 11(cpf) or 14(cnpj) digits
        if (strlen($value) !== 11 && strlen($value) !== 14) {
            return false;
        }

        //validate if the document has only numbers
        for ($i = 0; $i < strlen($value); $i++) {
            if (!is_numeric($value[$i])) {
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return 'Insert a valid CPF or CNPJ!';
    }
}
