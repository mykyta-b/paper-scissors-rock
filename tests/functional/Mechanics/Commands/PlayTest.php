<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands\Play;


use PHPUnit\Framework\TestCase;
use PSRG\DI;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\Tests\Functional\Mechanics\Commands\GameIsHangingTestException;
use PSRG\Tests\Functional\Mechanics\Commands\PlayCommandForTests;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

/**
 * @group functional
 * @group Mechanics
 */
class PlayTest extends TestCase
{
    use GamePreSetUpTrait;

    /**
     * @test
     * @dataProvider playStateTestDataProvider
     * @param array $usedCells
     * @param int $playBoardSize
     * @param array $expectedPlayerTurns
     * @param array $expected
     */
    public function checkPlayCommand(array $usedCells, int $playBoardSize, array $expectedPlayerTurns, array $expected)
    {
        $this->setUpGame($playBoardSize);
        $this->syncWithBoard($usedCells, $this->gameDTO->getBoardDTO());
        $di = $this->getDI($expectedPlayerTurns);
        $playStateCommand = $di->createTestPlayCommand();
        $gameState = $di->createGameState();

        $gameState->changeState(MechanicsConstants::PLAY);
        $this->gameDTO->setState(MechanicsConstants::PLAY);
        if (isset($expected['exception'])) {
            $this->expectException($expected['exception']);
        }

        ob_start();

        $playStateCommand->execute($this->gameDTO, $gameState);

        ob_end_clean();

        $this->assertEquals($expected['state'], $this->gameDTO->getState());
        $this->assertEquals($expected['state'], $gameState->getCurrentState());
    }

    /**
     * @param array $expectedPlayerTurns
     * @return DI
     */
    protected function getDI(array $expectedPlayerTurns): DI
    {

        $di = (new class($expectedPlayerTurns) extends DI {

            private $expectedPlayerTurns;

            public function __construct($expectedPlayerTurns)
            {
                $this->expectedPlayerTurns = $expectedPlayerTurns;
            }

            public function createTestPlayCommand()
            {
                return $this->createPlayCommand();
            }

            protected function createPlayCommand() {

                return new PlayCommandForTests(
                    $this->createRenderer(),
                    $this->createInputRequest(),
                    $this->createBoardBuilder(),
                    $this->createAutoPlayer(),
                    $this->createGameStateAnalyzer(),
                    $this->expectedPlayerTurns
                );
            }
        });

        return $di;
    }

    /**
     * @return array
     */
    public function playStateTestDataProvider(): array
    {
        return [
            [
                [
                    'D1' => 'Z',
                    'D2' => 'Z',
                    'D3' => 'Z',
                    'B1' => 'X',
                    'C3' => '0',

                ],
                4,
                [
                    'player1' => 'A1',
                    'player2' => 'A2',
                    'computer' => 'D4',
                ],
                [
                    'state' => MechanicsConstants::WIN,
                ]
            ],

            [
                [

                    'A3' => '0',
                    'B1' => 'X',
                    'B2' => 'X',
                    'B3' => 'Z',
                    'C1' => 'Z',
                    'C2' => '0',
                    'C3' => '0',
                    'C4' => '0',
                    'D1' => 'X',
                    'D2' => 'Z',
                    'D3' => 'Z',

                ],
                4,
                [
                    'player1' => 'A1',
                    'player2' => 'A2',
                    'computer' => 'D4',
                ],
                [
                    'state' => MechanicsConstants::DRAW,
                ]
            ],

            [
                [
                    'D1' => 'Z',
                    'D2' => 'Z',
                    'D3' => 'Z',
                    'B1' => 'X',
                    'C3' => '0',

                ],
                4,
                [
                    'player1' => 'A1',
                    'player2' => 'A2',
                    'computer' => 'D3',
                ],
                [
                    'state' => MechanicsConstants::PLAY,
                    'exception' => GameIsHangingTestException::class
                ]
            ],
        ];
    }
}
