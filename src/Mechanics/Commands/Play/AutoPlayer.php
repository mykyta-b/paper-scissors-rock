<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands\Play;


use PSRG\Core\DTO\PlayerDTO;
use PSRG\Mechanics\MechanicsConstants;

/**
 * @group Mechanics
 */
class AutoPlayer implements PlayerTurnInterface
{

    public function getNextTurn(PlayerDTO $player): string
    {
        $method = $this->getFabricMethodName($player);

        return $this->$method();
    }

    /**
     * @param PlayerDTO $player
     * @return string
     */
    private function getFabricMethodName(PlayerDTO $player)
    {
        return sprintf("get%sStrategyTurn", ucfirst($player->getStrategy()));
    }

    /**
     * @return string
     */
    protected function getPaperStrategyTurn()
    {
        return MechanicsConstants::PAPER;
    }

    /**
     * @return string
     */
    protected function getRandomStrategyTurn(): string
    {
        $turnVariationsCount = count(MechanicsConstants::PLAYER_TURN_OPTIONS);
        $randomOptionIndex = rand(0, $turnVariationsCount - 1);

        return MechanicsConstants::PLAYER_TURN_OPTIONS[$randomOptionIndex];
    }

}
