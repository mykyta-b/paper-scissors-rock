<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\State;


use PSRG\Core\State\Exception\IncorrectStateTransitionException;

class GameState implements GameStateInterface
{
    const ALLOW = [
        GameStateConstants::BEGIN => [
            GameStateConstants::PLAY,
            GameStateConstants::END,
        ],

        GameStateConstants::PLAY => [
            GameStateConstants::WIN,
            GameStateConstants::DRAW,
            GameStateConstants::END,
            GameStateConstants::PLAY,
        ],

        GameStateConstants::DRAW => [
            GameStateConstants::END
        ],

        GameStateConstants::WIN => [
            GameStateConstants::END
        ],

        GameStateConstants::END => [],
    ];

    protected $currentState = GameStateConstants::START_STATE;

    protected function isAllowed($currentState, $nextState)
    {
        return
            isset(self::ALLOW[$currentState]) &&
            isset(self::ALLOW[$nextState]) &&
            in_array($nextState, self::ALLOW[$currentState]);
    }

    /**
     * @param $nextState
     */
    public function changeState($nextState): void
    {
        if ($this->isAllowed($this->currentState, $nextState)) {
            $this->currentState = $nextState;
        } else {
            throw new IncorrectStateTransitionException("Transition to state $nextState is prohibited from {$this->getCurrentState()}");
        }
    }

    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @return bool
     */
    public function gameNotOver()
    {
       return $this->getCurrentState() !== GameStateConstants::END;
    }

    /**
     * @param string $state
     * @return bool
     */
    public function gameStateIsEqual(string $state): bool
    {
        return $this->getCurrentState() === $state;
    }

    /**
     * @return bool
     */
    public function gameStateIsPlay(): bool
    {
        return $this->getCurrentState() === GameStateConstants::PLAY;
    }
}
