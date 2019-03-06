<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;

use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateInterface;

interface CommandInterface
{
    public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void;
    public function shouldBeRunWithGameState(string $stateName): bool;
}
