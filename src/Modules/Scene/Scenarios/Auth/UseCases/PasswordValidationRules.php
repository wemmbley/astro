<?php

namespace Modules\Scene\Scenarios\Auth\UseCases;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::default(),
            'confirmed'
        ];
    }
}
