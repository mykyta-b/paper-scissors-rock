<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics;


use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\State\GameStateConstants;

interface MechanicsConstants
{
    const PLAY = GameStateConstants::PLAY;
    const END = GameStateConstants::END;
    const BEGIN = GameStateConstants::BEGIN;
    const DRAW = GameStateConstants::DRAW;
    const WIN = GameStateConstants::WIN;

    const PLAYER_TYPE_COMPUTER = ConfigConstants::PLAYER_TYPE_COMPUTER;
    const PLAYER_TYPE_HUMAN = ConfigConstants::PLAYER_TYPE_HUMAN;

    const PAPER = "P";
    const SCISSORS = "S";
    const ROCK = "R";

    const PLAYER_TURN_OPTIONS = [self::PAPER, self::SCISSORS, self::ROCK];
    const MAX_PLAYER_NUMBER = ConfigConstants::NUMBER_OF_PLAYERS;
}
