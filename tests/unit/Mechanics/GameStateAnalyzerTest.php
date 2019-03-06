<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Mechanics;


use PHPUnit\Framework\TestCase;
use PSRG\Core\DTO\GameDTO;
use PSRG\Mechanics\GameStateAnalyzer;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

/**
 * @group Mechanics
 */
class GameStateAnalyzerTest extends TestCase
{
    use GamePreSetUpTrait;

    public function setUp()
    {
       parent::setUp();
       $this->setUpGame();
    }

    /**
     * @dataProvider noWinDataProvider
     * @param array $turns
     * @param mixed $expectedWinner
     */
    public function checkIfNoWin(array $turns, $expectedWinner): void
    {
        $this->setUpTurns($this->gameDTO, $turns);
        $gameStateAnalyzer = new GameStateAnalyzer();
        $gameStateAnalyzer->findWinner($this->gameDTO);
        $this->assertEquals($expectedWinner, $this->gameDTO->getWinner());
    }

    /**
     * @return array
     */
    public function noWinDataProvider(): array
    {
        return [
            [
                [

                ],
                null
            ],
            [
                [
                    'player1' => "S",
                    'player2' => "S",

                ],
                null
            ],[
                [
                    'player1' => "R",
                    'player2' => "R",

                ],
                null
            ],[
                [
                    'player1' => "P",
                    'player2' => "P",

                ],
                null
            ],
        ];
    }

    /**
     * @test
     * @dataProvider winDataProvider
     * @param array $turns
     * @param mixed $expectedWinnerAlias
     */
    public function checkIfWin(array $turns, $expectedWinnerAlias)
    {
        $this->setUpTurns($this->gameDTO, $turns);
        $gameStateAnalyzer = new GameStateAnalyzer();
        $gameStateAnalyzer->findWinner($this->gameDTO);
        $this->assertEquals($expectedWinnerAlias, $this->gameDTO->getWinner()->getAlias());
    }
    public function winDataProvider()
    {
        return [
            [
                [
                    'player1' => "S",
                    'player2' => "P",

                ],
                'player1'
            ],
            [
                [
                    'player1' => "P",
                    'player2' => "R",

                ],
                'player1'
            ],            [
                [
                    'player1' => "R",
                    'player2' => "S",

                ],
                'player1'
            ],
            [
                [
                    'player1' => "P",
                    'player2' => "S",

                ],
                'player2'
            ],
            [
                [
                    'player1' => "R",
                    'player2' => "P",

                ],
                'player2'
            ],            [
                [
                    'player1' => "S",
                    'player2' => "R",

                ],
                'player2'
            ],
        ];
    }

    /**
     * @param GameDTO $gameDTO
     * @param array $turns
     */
    private function setUpTurns(GameDTO $gameDTO, array $turns): void
    {
        foreach ($turns as $playerAlias => $turn) {
            foreach ($this->gameDTO->getPlayers() as $playerDTO) {
                if ($playerAlias === $playerDTO->getAlias()) {
                    $playerDTO->setTurn($turn);
                }
            }
        }
    }

}
