<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config;


interface ConfigConstants
{
    const NUMBER_OF_PLAYERS = 2;

    const PLAYER_NAME_KEY = 'name';
    const PLAYER_STRATEGY_KEY = 'strategy';
    const PLAYER_TYPE_KEY = 'type';
    const PLAYER_ALLOWABLE_TYPES = [self::PLAYER_TYPE_COMPUTER, self::PLAYER_TYPE_HUMAN];


    const PLAYER_RANDOM_STRATEGY = 'random';
    const PLAYER_PAPER_STRATEGY = 'paper';
    const PLAYER_ALLOWABLE_STRATEGIES = [self::PLAYER_RANDOM_STRATEGY, self::PLAYER_PAPER_STRATEGY];

    const PLAYER_TYPE_COMPUTER = 'computer';
    const PLAYER_TYPE_HUMAN = 'human';

    const PLAYER_CONFIG_OPTION = 'player_configuration';
    const STATS_CONFIG_OPTION = 'game_stats';
    const STATS_CONFIG_FILE_KEY = 'statFile';
}
