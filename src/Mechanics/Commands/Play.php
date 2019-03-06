<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;


use PSRG\Core\DTO\GameDTO;
use PSRG\Core\DTO\PlayerDTO;
use PSRG\Core\State\GameStateInterface;
use PSRG\Core\Stats\GameStatisticInterface;
use PSRG\Mechanics\Commands\Exception\GameIsHangingException;
use PSRG\Mechanics\Commands\Play\PlayerTurn;
use PSRG\Mechanics\GameStateAnalyzer;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\UI\InputRequestInterface;
use PSRG\UI\RendererInterface;

class Play extends CommandTemplate
{

    /**
     * @var string
     */
    protected $commandState = MechanicsConstants::PLAY;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @var InputRequestInterface
     */
    protected $inputRequest;

    /**
     * @var PlayerTurn
     */
    protected $turnMaker;

    /**
     * @var GameStateAnalyzer
     */
    protected $gameStateAnalyzer;

    /**
     * @var GameStatisticInterface
     */
    protected $gameStatistic;

    public function __construct(
        RendererInterface $renderer,
        InputRequestInterface $inputRequest,
        PlayerTurn $turnMaker,
        GameStateAnalyzer $gameStateAnalyzer,
        GameStatisticInterface $gameStatistic
    ) {
        $this->renderer = $renderer;
        $this->inputRequest = $inputRequest;
        $this->turnMaker = $turnMaker;
        $this->gameStateAnalyzer = $gameStateAnalyzer;
        $this->gameStatistic = $gameStatistic;
    }

    /**
     * @param GameDTO $gameDTO
     * @param GameStateInterface $gameState
     */
    public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void
    {

        foreach ($gameDTO->getPlayers() as $player) {
            $this->renderer->renderSeparator();
            $this->renderer->renderPhrase($player->getAlias());
            $playerResponse = $this->getNextTurn($player);
            $player->setTurn($playerResponse);
        }

        $this->gameStateAnalyzer->findWinner($gameDTO);
        if ($gameDTO->getWinner()) {
            $playIsEndedWithState = MechanicsConstants::WIN;
        } else {
            $playIsEndedWithState = MechanicsConstants::DRAW;
        }

        $this->gameStatistic->updateStats($gameDTO);
        $gameState->changeState($playIsEndedWithState);
        $gameDTO->setState($playIsEndedWithState);
    }

    /**
     * @param PlayerDTO $player
     * @return string
     */
    protected function getNextTurn(PlayerDTO $player): string
    {
        return $this->turnMaker->getNextTurn($player);
    }
}
