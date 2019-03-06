<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Helpers\Traits;


use PSRG\Core\Builder\BoardBuilderInterface;
use PSRG\Core\Config\GameSettingsDTO;
use PSRG\Core\DTO\BoardDTO;
use PSRG\Core\DTO\GameDTO;
use PSRG\DI;

trait GamePreSetUpTrait
{
    /**
     * @var GameDTO
     */
    protected $gameDTO;

    protected function setUpGame($playerSettings = []): void
    {
        $container = new DI();

        $playerSettings = empty($playerSettings) ? $this->getDefaultPlayerSettings() : $playerSettings;

        $gameSettingsDTO = $this->createSettingsDTO($playerSettings);
        $this->gameDTO = $container->createGameBuilder()->buildGameDTO($gameSettingsDTO);
    }

    /**
     * @param $playerSettings
     * @return GameSettingsDTO
     */
    protected function createSettingsDTO($playerSettings): GameSettingsDTO
    {
        $gameSettingsDTO = (new GameSettingsDTO())
            ->setPlayerSettings($playerSettings);
        return $gameSettingsDTO;
    }

    protected function getDefaultPlayerSettings()
    {
        return  [

                'player1' => [
                    'name' => 'Custom1_name',
                    'type' => 'human',
                ],
                'player2' => [
                    'name' => 'Super_computer',
                    'strategy' => 'paper',
                    'type' => 'computer',
                ],
        ];
    }

}
