<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics;

use PSRG\Core\DTO\GameDTO;

class GameStateAnalyzer
{

    const FIRST_PLAYER_WON = [
        ["S", "P"],
        ["P", "R"],
        ["R", "S"],
    ];

    const SECOND_PLAYER_WON = [
        ["P", "S"],
        ["R", "P"],
        ["S", "R"],
    ];

    /**
     * @param GameDTO $gameDTO
     * @return mixed
     */
    public function findWinner(GameDTO $gameDTO): void
    {

        $turns = [];
        $players = $gameDTO->getPlayers();
        foreach ($players as $playerDTO) {
            $turns[$playerDTO->getAlias()] = $playerDTO->getTurn();
        }

        if ($this->checkIfPlayerWon(array_values($turns), self::FIRST_PLAYER_WON)) {
            $gameDTO->setWinner($players[0]);
            return;
        }

        if ($this->checkIfPlayerWon(array_values($turns), self::SECOND_PLAYER_WON)) {
            $gameDTO->setWinner($players[1]);
            return;
        }
    }


    /**
     * @param GameDTO $gameDTO
     * @return bool
     */
    public function isDraw(GameDTO $gameDTO)
    {
        $turns = [];
        foreach ($gameDTO->getPlayers() as $playerDTO) {
            !isset($turns[$playerDTO->getTurn()]) ? $turns[$playerDTO->getTurn()] = 1: $turns[$playerDTO->getTurn()]++;
        }

        $isDraw = false;

        foreach ($turns as $key => $value) {
            if ($value === MechanicsConstants::MAX_PLAYER_NUMBER) {
                $isDraw = true;
                break;
            }
        }

        return $isDraw;
    }

    /**
     * @param array $turns
     * @param array $variants
     * @return bool
     */
    protected function checkIfPlayerWon(array $turns, array $variants): bool
    {
        foreach ($variants as $variant) {
            if ($turns === $variant) {
                return true;
            }
        }

        return false;
    }


}
