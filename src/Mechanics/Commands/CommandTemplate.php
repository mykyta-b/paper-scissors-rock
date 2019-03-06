<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;


use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateConstants;
use PSRG\Core\State\GameStateInterface;

abstract class CommandTemplate implements CommandInterface
{
    protected $commandState = GameStateConstants::ERROR;

    abstract public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void;

    public function shouldBeRunWithGameState(string $stateName): bool
    {
        return $this->commandState === $stateName;
    }
}
