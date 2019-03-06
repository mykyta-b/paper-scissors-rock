<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Stats;


use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\DTO\GameDTO;

class GameStatistic implements GameStatisticInterface
{
    /**
     * @var StatsFileReader
     */
    protected $statFileReader;

    /**
     * @param StatsFileReader $statFileReader
     */
    public function __construct(StatsFileReader $statFileReader)
    {
        $this->statFileReader = $statFileReader;
    }

    /**
     * @param GameDTO $gameDTO
     * @throws Exceptions\CanNotAccessStatsFileReadException
     */
    public function updateStats(GameDTO $gameDTO): void
    {
        $statsFileName = $gameDTO->getGameSettings()->getStatSettings()[ConfigConstants::STATS_CONFIG_FILE_KEY];

        $stats = $this->readCurrentStat($statsFileName);

        $stats = $this->updateGameNumberStat($gameDTO, $stats);

        if ($gameDTO->getWinner() !== null) {
            $stats = $this->incrementKey($stats, $gameDTO->getWinner()->getAlias(), StatsConstants::WIN_KEY);
            $loserAlias = $this->getLoserAlias($gameDTO);
            $stats = $this->incrementKey($stats, $loserAlias, StatsConstants::LOSE_KEY);
        } else {
            foreach ($gameDTO->getPlayers() as $playerDTO) {
                $stats = $this->incrementKey($stats, $playerDTO->getAlias(), StatsConstants::DRAW_KEY);
            }
        }

        $this->statFileReader->updateStats($statsFileName, $stats);
    }

    /**
     * @param string $fileName
     * @return array
     * @throws Exceptions\CanNotAccessStatsFileReadException
     */
    public function readCurrentStat(string $fileName): array
    {
        return $this->statFileReader->readStats($fileName);
    }

    /**
     * @param array $stats
     * @param string $playerAlias
     * @param string $statsKey
     * @return mixed
     */
    protected function incrementKey(array $stats, string $playerAlias, string $statsKey)
    {
        isset($stats[$playerAlias][$statsKey]) ?
            $stats[$playerAlias][$statsKey]++ : $stats[$playerAlias][$statsKey] = 1;
        return $stats;
    }

    /**
     * @param GameDTO $gameDTO
     * @param $stats
     * @return mixed
     */
    protected function updateGameNumberStat(GameDTO $gameDTO, $stats)
    {
        foreach ($gameDTO->getPlayers() as $playerDTO) {
            $stats = $this->incrementKey($stats, $playerDTO->getAlias(), StatsConstants::GAME_KEY);
        }
        return $stats;
    }

    /**
     * @param GameDTO $gameDTO
     * @return string
     */
    protected function getLoserAlias(GameDTO $gameDTO): string
    {
        foreach ($gameDTO->getPlayers() as $playerDTO) {
            if ($playerDTO->getAlias() !== $gameDTO->getWinner()->getAlias()) {
                return $playerDTO->getAlias();
            }
        }
    }
}