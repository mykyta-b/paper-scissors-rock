<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Builder;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Config\ConfigConstants;
use PSRG\DI;
use PSRG\Tests\Helpers\Traits\GamePreSetUpTrait;

class PlayerBuilderTest extends TestCase
{
    use GamePreSetUpTrait;

    /**
     * @dataProvider configDataProvider
     * @param array $playerSettings
     */
    public function testMeTest(array $playerSettings): void
    {
        $gameSettingsDTO = $this->createSettingsDTO($playerSettings);

        $di = new DI();
        $players = $di->createPlayersBuilder()->createPlayers($gameSettingsDTO);

        for($i = 0; $i < ConfigConstants::NUMBER_OF_PLAYERS; $i++) {

            $playerAlias = sprintf('player%s', $i + 1);
            $this->assertEquals(

                $playerSettings[$playerAlias][ConfigConstants::PLAYER_NAME_KEY],
                $players[$i]->getName()
            );

            $this->assertEquals(
                $playerSettings[$playerAlias][ConfigConstants::PLAYER_TYPE_KEY],
                $players[$i]->getType()
            );

            if ( $playerSettings[$playerAlias][ConfigConstants::PLAYER_TYPE_KEY] === ConfigConstants::PLAYER_TYPE_HUMAN) {
                $this->assertNull($players[$i]->getStrategy());
            } else {
                $this->assertEquals($playerSettings[$playerAlias][ConfigConstants::PLAYER_STRATEGY_KEY], $players[$i]->getStrategy());
            }
        }



    }

    public function configDataProvider()
    {
        return [
            [
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
            ],
            [
                'player_configuration' => [
                    'player1' => [
                        'name' => 'Custom1_name',
                        'strategy' => 'random',
                        'type' => 'computer',
                    ],
                    'player2' => [
                        'name' => 'Custom_name',
                        'type' => 'human',
                    ],
                ]
            ]
        ];
    }

}