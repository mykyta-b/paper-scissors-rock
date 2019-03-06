<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;


use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateInterface;
use PSRG\Core\Stats\GameStatisticInterface;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\UI\RendererInterface;

class End extends CommandTemplate
{
    protected $commandState = MechanicsConstants::END;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @var GameStatisticInterface
     */
    protected $gameStatistic;

    public function __construct(
        RendererInterface $renderer,
        GameStatisticInterface $gameStatistic
    ) {
        $this->renderer = $renderer;
        $this->gameStatistic = $gameStatistic;
    }

    public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void
    {
        $this->renderer->renderSeparator();
        $this->renderer->renderPhrase("Game Over!");
        $this->renderer->renderStatistic(
            $this->gameStatistic->readCurrentStat($gameDTO->getGameSettings()->getStatSettings()[ConfigConstants::STATS_CONFIG_FILE_KEY])
        );
    }
}
