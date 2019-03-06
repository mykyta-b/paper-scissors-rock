<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\State;


interface GameStateInterface
{
    /**
     * @param $nextState
     * @return mixed
     */
    public function changeState($nextState);

    public function getCurrentState();

    public function gameNotOver();

    /**
     * @param string $state
     * @return bool
     */
    public function gameStateIsEqual(string $state): bool;

    /**
     * @return bool
     */
    public function gameStateIsPlay(): bool;

}
