<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Core\Config;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Config\ConfigParser;
use PSRG\Core\Config\GameSettingsDTO;

/**
 * @group unit
 * @group Core
 */
class ConfigReaderTest extends TestCase
{
    /**
     * @var ConfigParser
     */
    protected $configReader;

    /**
     * @var string
     */
    protected $fixturePath;

    public function setUp()
    {
        $this->fixturePath = dirname(__FILE__) . '/../../../fixtures/Config/game.good.ini';
        $this->configReader = new ConfigParser();
    }

    /**
     * @test
     */
    public function testReadConfig(): void
    {
        $settingsDTO = $this->configReader->parseConfigFile($this->fixturePath);
        $this->assertEquals(GameSettingsDTO::class, get_class($settingsDTO));
    }

    /**
     * @test
     * @expectedException \PSRG\Core\Config\Exception\CannotReadConfigFileException
     * @expectedExceptionMessageRegExp /Configuration file .* does not exist/
     */
    public function testReadConfigException(): void
    {
        $settingsDTO = $this->configReader->parseConfigFile($this->fixturePath . '+error');
    }
}
