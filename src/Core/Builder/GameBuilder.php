<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Builder;


use PSRG\Core\Config\GameSettingsDTO;
use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateConstants;

class GameBuilder
{
    /**
     * @var PlayersBuilder
     */
    protected $playersBuilder;

    public function __construct(
        PlayersBuilder $playersBuilder
    ) {
        $this->playersBuilder = $playersBuilder;
    }

    public function buildGameDTO(GameSettingsDTO $gameSettingsDTO): GameDTO
    {
        return (new GameDTO())
            ->setPlayers($this->playersBuilder->createPlayers($gameSettingsDTO))
            ->setGameSettings($gameSettingsDTO)
            ->setState(GameStateConstants::START_STATE)
            ;
    }
}
