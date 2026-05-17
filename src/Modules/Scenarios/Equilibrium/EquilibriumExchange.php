<?php

namespace Modules\Scenarios\Equilibrium;

use Modules\Actors\Equilibrium\Equilibrium;
use Modules\Scene\Scenarios\Equilibrium\UserAccountRepository;

class EquilibriumExchange
{
    public function __construct(
        private UserAccountRepository $userAccountRepository,
    ) {}

    public function getCurrentEquilibrium(int $userId): Equilibrium
    {
        $rawQuanta = $this->userAccountRepository->getBalanceByUserId($userId);

        return Equilibrium::fromQuanta($rawQuanta);
    }

    public function withdraw(int $userId, int $amountToTake): void
    {
        $this->userAccountRepository->protect(function() use($userId, $amountToTake) {
            $currentEquilibrium = $this->getCurrentEquilibrium($userId);
            $requiredEnergy = Equilibrium::fromQuanta($amountToTake);
            $newEquilibrium = $currentEquilibrium->take($requiredEnergy);

            $this->userAccountRepository->updateBalance(
                $userId,
                $newEquilibrium->getQuanta()
            );
        });
    }
}
