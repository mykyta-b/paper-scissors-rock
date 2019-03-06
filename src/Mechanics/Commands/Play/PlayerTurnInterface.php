<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands\Play;

use PSRG\Core\DTO\PlayerDTO;

interface PlayerTurnInterface
{
    public function getNextTurn(PlayerDTO $player): string;
}
