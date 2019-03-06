<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Stats;


use PSRG\Core\Stats\Exceptions\CanNotAccessStatsFileReadException;

class StatsFileReader
{
    /**
     * @param string $configFile
     * @return array
     * @throws CanNotAccessStatsFileReadException
     */
    public function readStats(string $configFile): array
    {
        if (!file_exists($configFile)) {
            $this->createNewStatsFile($configFile);
        }

        return unserialize(file_get_contents($configFile));

    }

    /**
     * @param string $configFile
     * @param array $stats
     * @return int
     */
    public function updateStats(string $configFile, array $stats): int
    {
        return file_put_contents($configFile, serialize($stats));
    }

    private function createNewStatsFile($configFile)
    {
        if (!@file_put_contents($configFile, serialize([]))) {
            throw new CanNotAccessStatsFileReadException(
                vsprintf("Can not access stats file %s. File does not exists", [$configFile])
            );
        }

    }
}