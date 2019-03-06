<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Unit\Mechanics\Commands;


use PHPUnit\Framework\TestCase;
use PSRG\Core\State\GameState;
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


        $endStateCommand = new End($rendererMock);
        $endStateCommand->execute($this->gameDTO, new GameState());
    }
}