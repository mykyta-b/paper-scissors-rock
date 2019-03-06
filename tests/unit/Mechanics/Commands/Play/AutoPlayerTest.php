<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Mechanics\Commands\Play;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\DTO\PlayerDTO;
use PSRG\Mechanics\Commands\Play\AutoPlayer;
use PSRG\Mechanics\MechanicsConstants;

class AutoPlayerTest extends TestCase
{
    /**
     * @var AutoPlayer
     */
    protected $autoPlayer;

    public function setUp()
    {
        $this->autoPlayer = new AutoPlayer();
    }

    public function testPaperStrategy(): void
    {
        $player = (new PlayerDTO())
            ->setName('name')
            ->setType(ConfigConstants::PLAYER_TYPE_COMPUTER)
            ->setStrategy(ConfigConstants::PLAYER_PAPER_STRATEGY)
        ;

        $playerTurn = $this->autoPlayer->getNextTurn($player);

        $this->assertEquals(MechanicsConstants::PAPER, $playerTurn);
    }

    public function testRandomStrategy(): void
    {
        $player = (new PlayerDTO())
            ->setName('name')
            ->setType(ConfigConstants::PLAYER_TYPE_COMPUTER)
            ->setStrategy(ConfigConstants::PLAYER_RANDOM_STRATEGY)
        ;

        $playerTurn = $this->autoPlayer->getNextTurn($player);

        $this->assertTrue(in_array($playerTurn, MechanicsConstants::PLAYER_TURN_OPTIONS));
    }
}
