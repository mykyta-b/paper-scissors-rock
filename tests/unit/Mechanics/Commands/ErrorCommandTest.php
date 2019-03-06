<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Unit\Mechanics\Commands;


use PHPUnit\Framework\TestCase;
use PSRG\Core\State\GameState;
use PSRG\Mechanics\Commands\Error;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;
use PSRG\UI\RendererInterface;

class ErrorCommandTest extends TestCase
{
    use GamePreSetUpTrait;

    public function testErrorCommand()
    {
        $this->setUpGame();
        $rendererMock  =  $this->createMock(RendererInterface::class);
        $rendererMock->expects($this->once())->method('renderPhrase')->willReturn([]);
        $rendererMock->expects($this->once())->method('renderSeparator')->willReturn([]);

        $endStateCommand = new Error($rendererMock);
        $endStateCommand->execute($this->gameDTO, new GameState());
    }
}
