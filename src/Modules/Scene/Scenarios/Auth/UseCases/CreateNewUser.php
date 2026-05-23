<?php

namespace Modules\Scene\Scenarios\Auth\UseCases;

use Database\Models\Social\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Modules\Actors\Auth\AuthRole;

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

        $user = User::create([
            'name' => $this->generateAnonymousName(),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole(AuthRole::User->name);

        return $user;
    }

    /**
     * Генерирует уникальное имя через количество существующих пользователей.
     */
    private function generateAnonymousName(): string
    {
        $count = User::count();
        $nextNumber = $count + 1;

        $name = "Anonymous{$nextNumber}";

        while (User::where('name', $name)->exists()) {
            $nextNumber++;
            $name = "Anonymous{$nextNumber}";
        }

        return $name;
    }
}
