<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Unit\Mechanics\Commands;


use PHPUnit\Framework\TestCase;
use PSRG\Core\State\GameState;
use PSRG\Core\Stats\GameStatisticInterface;
use PSRG\Mechanics\Commands\End;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;
use PSRG\UI\RendererInterface;

class EndCommandTest extends TestCase
{
    use GamePreSetUpTrait;

    /**
     * @test
     */
    public function testCommand()
    {
        $this->setUpGame();
        $rendererMock  =  $this->createMock(RendererInterface::class);
        $rendererMock->expects($this->once())->method('renderPhrase')->willReturn([]);
        $rendererMock->expects($this->once())->method('renderSeparator')->willReturn([]);

        $gameStatistics  =  $this->createMock(GameStatisticInterface::class);
        $gameStatistics->expects($this->once())->method('readCurrentStat')->willReturn([]);

        $endStateCommand = new End($rendererMock, $gameStatistics);
        $endStateCommand->execute($this->gameDTO, new GameState());
    }
}
