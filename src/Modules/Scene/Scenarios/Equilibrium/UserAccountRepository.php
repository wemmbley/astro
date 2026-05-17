<?php

namespace Modules\Scene\Scenarios\Equilibrium;

use Database\Models\Social\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class UserAccountRepository
{
    public function getBalanceByUserId(int $userId): int
    {
        $user = User::query()
            ->where('id', $userId)
            ->select('balance')
            ->lockForUpdate()
            ->first();

        if (!$user) {
            throw new RuntimeException("Актор с ID {$userId} не материализован на Сцене.");
        }

        return (int) $user->balance;
    }

    public function updateBalance(int $userId, int $amount): void
    {
        $updated = User::query()
            ->where('id', $userId)
            ->update([
                'balance' => $amount,
            ]);

        if (!$updated) {
            throw new RuntimeException("Не удалось обновить Эквилибриум для Актора {$userId}.");
        }
    }

    public function protect(callable $callable)
    {
        return DB::transaction($callable);
    }
}
