<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;


use PSRG\Mechanics\MechanicsConstants;

interface UIConstants
{
    const TURN_ALIASES = [
        MechanicsConstants::PAPER => "Paper",
        MechanicsConstants::SCISSORS => "Scissors",
        MechanicsConstants::ROCK => "Rock",
    ];
}