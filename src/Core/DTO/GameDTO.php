<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\DTO;


use PSRG\Core\Config\GameSettingsDTO;

class GameDTO
{
    /**
     * @var PlayerDTO[]
     */
    protected $players = [];

    /**
     * @var string
     */
    protected $state;

    /**
     * @var GameSettingsDTO
     */
    protected $gameSettings;

    /**
     * @var PlayerDTO
     */
    protected $winner;

    /**
     * @return PlayerDTO
     */
    public function getWinner(): ?PlayerDTO
    {
        return $this->winner;
    }

    /**
     * @param PlayerDTO $winner
     * @return GameDTO
     */
    public function setWinner(PlayerDTO $winner): GameDTO
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return GameSettingsDTO
     */
    public function getGameSettings(): GameSettingsDTO
    {
        return $this->gameSettings;
    }

    /**
     * @param GameSettingsDTO $gameSettings
     * @return GameDTO
     */
    public function setGameSettings(GameSettingsDTO $gameSettings): GameDTO
    {
        $this->gameSettings = $gameSettings;
        return $this;
    }

    /**
     * @return PlayerDTO[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param PlayerDTO[] $players
     * @return GameDTO
     */
    public function setPlayers(array $players): GameDTO
    {
        $this->players = $players;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return GameDTO
     */
    public function setState(string $state): GameDTO
    {
        $this->state = $state;
        return $this;
    }


}
