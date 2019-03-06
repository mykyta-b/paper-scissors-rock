<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Core\Config;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\Config\ConfigParserInterface;
use PSRG\Core\Config\ConfigValidationDecorator;
use PSRG\Core\Config\Exception\IncorrectConfigValueException;
use PSRG\Core\Config\Exception\IncorrectPlayerNumberException;
use PSRG\Core\Config\GameSettingsDTO;

/**
 * @group unit
 * @group Core
 */
class ConfigValidationDecoratorTest extends TestCase
{
    /**
     * @test
     * @dataProvider getConfigs
     * @param array $settings
     * @param bool $exceptionExpected
     * @throws IncorrectConfigValueException
     * @throws IncorrectPlayerNumberException
     */
    public function checkValidation(array $settings, $exceptionExpected)
    {
        $configReaderMock = $this->createMock(ConfigParserInterface::class);
        $configReaderMock->method('parseConfigFile')->willReturn(
            (new GameSettingsDTO())->setPlayerSettings($settings[ConfigConstants::PLAYER_CONFIG_OPTION] ?? [])
        );

        $configValidator = new ConfigValidationDecorator($configReaderMock);

        if ($exceptionExpected) {
            $this->expectException($exceptionExpected);
            $configValidator->parseConfigFile('/path/to/config');
        } else {
            $result = $configValidator->parseConfigFile('/path/to/config');
            $this->assertEquals(GameSettingsDTO::class, get_class($result));
        }
    }

    public function getConfigs()
    {
        return [
            [
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
                ], null
            ],
            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'strategy' => 'random',
                            'type' => 'computer',
                        ],
                        'player2' => [
                            'name' => 'Custom_name',
                            'strategy' => 'paper',
                            'type' => 'computer',
                        ],
                    ]
                ], null
            ],
            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'strategy' => 'random',
                            'type' => 'computer',
                        ],
                        'player2' => [
                            'name' => 'Custom_name',
                            'strategy' => 'INCORRECT',
                            'type' => 'human',
                        ],
                    ]
                ], IncorrectConfigValueException::class
            ],
            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                        'player2' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                    ]
                ], IncorrectConfigValueException::class
            ],
            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                        'player2' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                    ]
                ], IncorrectConfigValueException::class
            ],
            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                        'player2' => [
                            'name' => 'Custom2_name',
                            'strategy' => 'random',
                            'type' => 'human',
                        ],
                    ]
                ], IncorrectConfigValueException::class
            ],

            [
                [
                    'player_configuration' => [
                        'player1' => [
                            'name' => 'Custom1_name',
                            'type' => 'human',
                        ],
                    ]
                ],
                IncorrectPlayerNumberException::class
            ],
            [
                [], IncorrectPlayerNumberException::class
            ],
        ];
    }
}
