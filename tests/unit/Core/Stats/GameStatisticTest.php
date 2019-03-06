<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Stats;


use PSRG\Core\Stats\GameStatistic;
use PHPUnit\Framework\TestCase;
use PSRG\Core\Stats\StatsConstants;
use PSRG\Core\Stats\StatsFileReader;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

class GameStatisticTest extends TestCase
{
    use GamePreSetUpTrait;

    /**
     * @dataProvider statisticDataProvider
     * @param array $stats
     * @param string $winnerAlias
     */
    public function testMeTest(array $stats, string $winnerAlias): void
    {

        $this->setUpGame();
        $statsReader = $this->createMock(StatsFileReader::class);
        $statsReader->
        expects($this->once())->
        method('readStats')->willReturn(
            $stats
        );

        $update = [];
        $statsReader->
        expects($this->once())->
        method('updateStats')->willReturn(
            true
        );

        $this->setUpWinner($winnerAlias);

        $gameStatistic = new GameStatistic($statsReader);
        $gameStatistic->updateStats($this->gameDTO);

    }

    /**
     * @param string $winnerAlias
     */
    protected function setUpWinner(string $winnerAlias): void
    {
        foreach ($this->gameDTO->getPlayers() as $playerDTO) {
            if ($playerDTO->getAlias() === $winnerAlias) {
                $this->gameDTO->setWinner($playerDTO);
                return;
            }
        }
    }

    public function statisticDataProvider()
    {
        return [
            [
                [
                    'player1' => [
                        StatsConstants::GAME_KEY => 1,
                        StatsConstants::WIN_KEY => 1,
                        StatsConstants::DRAW_KEY => 1,
                        StatsConstants::LOSE_KEY => 0
                    ],
                    'player2' => [
                        StatsConstants::GAME_KEY => 1,
                        StatsConstants::WIN_KEY => 0,
                        StatsConstants::DRAW_KEY => 1,
                        StatsConstants::LOSE_KEY => 1
                    ],
                ],
                'player1'
            ]
        ];
    }
}
