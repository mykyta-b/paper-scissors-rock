<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Stats;

use PSRG\Core\DTO\GameDTO;

interface GameStatisticInterface
{
    /**
     * @param GameDTO $gameDTO
     * @throws Exceptions\CanNotAccessStatsFileReadException
     */
    public function updateStats(GameDTO $gameDTO): void;

    /**
     * @param string $fileName
     * @return array
     * @throws Exceptions\CanNotAccessStatsFileReadException
     */
    public function readCurrentStat(string $fileName): array;
}