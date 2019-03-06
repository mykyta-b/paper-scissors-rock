<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Functional\Mechanics\Commands\Play;


use PHPUnit\Framework\TestCase;
use PSRG\Core\DTO\PlayerDTO;
use PSRG\DI;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

/**
 * @group functional
 * @group Mechanics
 */
class ComputerTurnMakerTest extends TestCase
{
    use GamePreSetUpTrait;

    /**
     * @var PlayerDTO
     */
    protected $player;

    public function setUp()
    {
        parent::setUp();
        $playBoardSize = 4;
        $this->setUpGame($playBoardSize);
        $this->player = (new PlayerDTO())
            ->setType('computer')
            ->setAlias('comp')
            ->setCharacter('Z');
    }

    /**
     * @test
     * @dataProvider turnTestUnusedCellsCreationDataProvider
     * @param array $usedCells
     */
    public function checkTurnIsOnUnusedCell(array $usedCells)
    {
        $this->syncWithBoard($usedCells, $this->gameDTO->getBoardDTO());
        $di = new DI();
        $computerTurnMaker = $di->createComputerTurnMaker();
        $cellAlias = $computerTurnMaker->getNextTurn($this->player, $this->gameDTO->getBoardDTO());
        $this->assertFalse(in_array($cellAlias, array_keys($usedCells)));
    }

    public function turnTestUnusedCellsCreationDataProvider(): array
    {
        return [
            [
                [
                    'D1' => 'Z',
                    'D2' => 'Z',
                    'B1' => 'X',
                    'C3' => '0',

                ],
                [
                    'A1' => 'Z',
                    'B1' => 'X',
                    'A2' => '0',
                    'C3' => '0',
                    'C2' => 'X'
                ],
            ]
        ];
    }

    /**
     * @test
     * @dataProvider computerTurnTestData
     * @param array $usedCells
     * @param $playBoardSize
     * @param $expectedResponse
     */
    public function testComputerTurns(array $usedCells, $playBoardSize, $expectedResponse)
    {
        $this->setUpGame($playBoardSize);
        $this->syncWithBoard($usedCells, $this->gameDTO->getBoardDTO());
        $di = new DI();
        $computerTurnMaker = $di->createComputerTurnMaker();
        $computerTurn = $computerTurnMaker->getNextTurn($this->player, $this->gameDTO->getBoardDTO());
        $this->assertEquals($expectedResponse, $computerTurn);
    }

    /**
     * @return array
     */
    public function computerTurnTestData(): array
    {
        return array_merge(
            $this->getTestDataForImportantCellsStrategy(),
            $this->getTestDataForAlmostFilledLines(),
            $this->getTestDataForMostCapturedLine()
        );
    }

    /**
     * @return array
     */
    public function getTestDataForImportantCellsStrategy(): array
    {
        return [
            [
                [
                    'A1' => 'Z',
                    'B1' => 'Z',
                    'A2' => '0',
                    'C3' => '0',

                ],
                3,
                'C1'
            ], [
                [
                    'A1' => 'Z',
                    'B1' => 'X',
                    'A2' => '0',
                    'C3' => '0',
                    'A3' => 'Z',
                    'B2' => 'Z',

                ],
                3,
                'C1'
            ], [
                [
                    'A1' => 'Z',
                    'B1' => 'X',
                    'A2' => '0',
                    'C2' => '0',
                    'A3' => 'Z',

                ],
                3,
                'B2'
            ],
            [
                [
                    'A1' => 'Z',
                    'B1' => 'X',
                    'A2' => '0',
                    'C2' => '0',
                    'A3' => 'Z',

                ],
                4,
                'D1'
            ],
            [
                [
                    'A1' => 'Z',
                    'B1' => 'X',
                    'B4' => 'X',
                    'A2' => '0',
                    'C2' => '0',
                    'A3' => 'Z',

                ],
                4,
                'D1'
            ],

        ];
    }

    protected function getTestDataForAlmostFilledLines()
    {
        return [
            [
                [
                    'A1' => '0',
                    'C1' => '0',
                    'A2' => 'X',
                    'B2' => 'X',
                    'C2' => 'X',
                    'B4' => 'X',
                    'A3' => 'Z',

                ],
                4,
                'D2'
            ],
            [
                [
                    'A1' => '0',
                    'C1' => '0',
                    'A2' => 'X',
                    'B2' => 'Z',
                    'C2' => 'X',
                    'B4' => 'X',
                    'A3' => 'Z',

                ],
                4,
                'D1'
            ],

        ];
    }

    /**
     * @return array
     */
    protected function getTestDataForMostCapturedLine()
    {
        return [
            [
                [
                    'A1' => '0',
                    'C1' => 'X',
                    'D1' => '0',
                    'A2' => 'Z',
                    'B2' => 'Z',
                    'B4' => 'X',
                    'A3' => 'Z',

                ],
                4,
                'C2'
            ],
        ];
    }
}
