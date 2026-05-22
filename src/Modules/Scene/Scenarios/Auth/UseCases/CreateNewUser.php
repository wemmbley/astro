<?php

namespace Modules\Scene\Scenarios\Auth\UseCases;

use Database\Models\Social\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make(
            $input,
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class, 'email'),
                ],
                'password' => [
                    ...$this->passwordRules(),
                    'confirmed',
                ],
            ]
        )->validate();

        return User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
