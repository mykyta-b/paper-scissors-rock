<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
declare(strict_types=1);

namespace PSRG\Tests\Unit\Core\GameState;


use PHPUnit\Framework\TestCase;
use PSRG\Core\State\Exception\IncorrectStateTransitionException;
use PSRG\Core\State\GameState;
use PSRG\Core\State\GameStateConstants;

/**
 * @group unit
 * @group Core
 */
class GameStateTest extends TestCase
{
    /**
     * @test
     */
    public function currentState(): void
    {
        $gameState = new GameState();

        $this->assertEquals($gameState->getCurrentState(), GameStateConstants::BEGIN);
    }

    /**
     * @test
     * @dataProvider provideStates
     */
    public function changeState(string $state, bool $noException): void
    {
        $gameState = new GameState();

        if ($noException) {
            $gameState->changeState($state);
            $this->assertEquals($gameState->getCurrentState(), $state);
        } else {
            $this->expectException(IncorrectStateTransitionException::class);
            $gameState->changeState($state);
        }

    }

    /**
     * @return array
     */
    public function provideStates(): array
    {
        return [
            [GameStateConstants::END, true],
            [GameStateConstants::PLAY, true],
            [GameStateConstants::WIN, false],
        ];
    }
}
