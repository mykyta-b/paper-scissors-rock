<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Mechanics;


use PHPUnit\Framework\TestCase;
use PSRG\DI;
use PSRG\Mechanics\Commands\Begin;
use PSRG\Mechanics\Commands\Draw;
use PSRG\Mechanics\Commands\Error;
use PSRG\Mechanics\Commands\Play;
use PSRG\Mechanics\Commands\Win;
use PSRG\Mechanics\MechanicsConstants;

/**
 * @group unit
 * @group Mechanics
 */
class CommandStrategyTest extends TestCase
{
    /**
     * @test
     * @dataProvider stateDataProvider
     * @param string $state
     * @param string $expectedCommandClass
     */
    public function testStrategy(string $state, string $expectedCommandClass)
    {
        $di = new Di();
        $commandStrategy = $di->createCommandsStrategy();
        $command = $commandStrategy->pickCommand($state);
        $this->assertEquals(get_class($command), $expectedCommandClass);
    }

    public function stateDataProvider()
    {
        return [
            [MechanicsConstants::BEGIN, Begin::class],
            [MechanicsConstants::PLAY, Play::class],
            [MechanicsConstants::WIN, Win::class],
            [MechanicsConstants::DRAW, Draw::class],
            [MechanicsConstants::END, Error::class],
            ['unknown state', Error::class],
        ];
    }
}