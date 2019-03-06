<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Helpers\Traits;


use PSRG\Core\Config\GameSettingsDTO;
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



        $gameSettingsDTO = $this->createSettingsDTO($playerSettings);
        $gameSettingsDTO->setStatSettings(
            ["statFile" => '/mock']
        );
        $this->gameDTO = $container->createGameBuilder()->buildGameDTO($gameSettingsDTO);
    }

    /**
     * @param $playerSettings
     * @return GameSettingsDTO
     */
    protected function createSettingsDTO($playerSettings): GameSettingsDTO
    {
        $playerSettings = empty($playerSettings) ? $this->getDefaultPlayerSettings() : $playerSettings;
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
