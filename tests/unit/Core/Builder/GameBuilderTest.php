<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Builder;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Builder\GameBuilder;
use PSRG\Core\Builder\PlayersBuilder;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

class GameBuilderTest extends TestCase
{
    use GamePreSetUpTrait;

    public function testGameDTOBuilder(): void
    {

        $playerBuilder = $this->createMock(PlayersBuilder::class);
        $playerBuilder->
        expects($this->once())->
        method('createPlayers')->willReturn(
            []
        );

        $gameBuilder = new GameBuilder($playerBuilder);
        $gameBuilder->buildGameDTO($this->createSettingsDTO($this->getConfigData()));

    }

    public function getConfigData()
    {
        return [

                'player_configuration' => [
                    'player1' => [
                        'name' => 'Custom1_name',
                        'type' => 'human',
                    ],
                    'player2' => [
                        'name' => 'Custom_name',
                        'type' => 'human',
                    ],
                ]
            ];
    }
}