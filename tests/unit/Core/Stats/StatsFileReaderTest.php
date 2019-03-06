<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\Stats;


use PHPUnit\Framework\TestCase;
use PSRG\Core\Stats\StatsFileReader;

class StatsFileReaderTest extends TestCase
{
    const TMP_TEST = '/tmp/test';

    /**
     * @test
     * @expectedExceptionMessageRegExp /Can not access stats file/
     * @expectedException  \PSRG\Core\Stats\Exceptions\CanNotAccessStatsFileReadException
     */
    public function testReadStatFromNonExistingFile(): void
    {
        $statsFileReader = new StatsFileReader();
        $statsFileReader->readStats('/file/does/not/exists');

        $this->assertEquals(true, true);
    }

    /**
     * @test
     */
    public function testReadStatFromExistingFile(): void
    {
        $statsFileReader = new StatsFileReader();
        $return = $statsFileReader->readStats(self::TMP_TEST);

        $this->assertEquals([], $return);
    }

    public function tearDown()
    {
        if (file_exists(self::TMP_TEST)) {
            unlink(self::TMP_TEST);
        }
    }
}
