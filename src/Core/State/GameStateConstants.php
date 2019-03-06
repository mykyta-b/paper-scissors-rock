<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\State;


interface GameStateConstants
{
    const BEGIN = 'begin';
    const PLAY = 'play';
    const WIN = 'win';
    const DRAW = 'draw';
    const END = 'game over';
    const ERROR = 'error';

    const START_STATE = self::BEGIN;

}
